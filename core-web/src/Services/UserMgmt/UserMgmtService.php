<?php
namespace App\Services\UserMgmt;

use App\Repositories\UserMgmt\UserMgmtRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserMgmt\RoleRepository;
use Carbon\Carbon;
use App\Repositories\UserMgmt\UserRoleRepository;
use Illuminate\Support\Facades\Session;
use App\Services\MenuMgmt\MenuMgmtService;
use Illuminate\Http\Request;
use App\Repositories\UserMgmt\AssignUserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class UserMgmtService
{

    const DEFAULT_ROLE_NAME = 'Landing Page Only';
    
    public function __construct(AssignUserRepository $assignUserRepository, UserMgmtRepository $userMgmtRepository, RoleRepository $roleRepository, UserRoleRepository $userRoleRepository, MenuMgmtService $menuMgmtService)
    {
        $this->userMgmtRepository = $userMgmtRepository;
        $this->roleRepository = $roleRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->menuMgmtService = $menuMgmtService;
        $this->assignUserRepository = $assignUserRepository;
    }
    
    public function index()
    {
        return $this->userMgmtRepository->all();
    }
    
    public function getStaffInfo(Request $request){
        
        $attributes = $request->all();
        
        $dataStaffInfo = $this->userMgmtRepository->staffInfomation($attributes['staffId']);
        
        return $dataStaffInfo;
        
    }
    
    public function appFunction($userId, $functionCode){
        return $this->assignUserRepository->getAppFunction($userId, $functionCode);
    }
    
    public function getSelectItemRole(){
        return $this->assignUserRepository->selectItemRole();
    }
    
    public function attemptLogin($credentials){
        
        $respond = $this->userMgmtRepository->attemptLogin($credentials);
        if (array_key_exists('status',$respond)){
            $flagCredentials = $respond['status'];
            if($flagCredentials){
                $user = $this->userMgmtRepository->getUserByStaffId($credentials['staff_no']);
                $infoStaff = $this->userMgmtRepository->staffInfomation($credentials['staff_no']);
                if(empty($user)){
                    // Create new user
                    $newUser = array(
                        'name' => $infoStaff['title'] . $infoStaff['name'],
                        'email' => $infoStaff['email'],
                        'staff_no' => $infoStaff['staffId'],
                        'active' => 'on',
                        'session_timeout' => null,
                        'invalid_count_login' => null,
                        'max_count_login' => null,
                        'last_login_date' => null,
                    ); 
                    $this->userMgmtRepository->createUser($newUser);
                    $user = $this->userMgmtRepository->getUserByStaffId($credentials['staff_no']);
                    
                    $role = $this->roleRepository->getRoleByName(self::DEFAULT_ROLE_NAME);                    
                    $newUserRole = array(
                        'user_id' => $user->id,
                        'role_id' => $role->id,
                        'start_date' => Carbon::now(),
                        'end_date' => null
                    );
                    $this->userRoleRepository->create($newUserRole);                    
                }
                if($user->invalid_count_login >= $user->max_count_login){
                    return 'invalidCount';
                }else  if($user->invalid_count_login >= $user->max_count_login){
                    return 'invalidCount';
                }else  if(!$user->active){
                    return 'inactiveAcc';
                }else{
                    Auth::loginUsingId($user->id);
                    Session::put('department_code', $infoStaff['department_code']);
                    Session::put('menu_user', $this->menuMgmtService->renderMenu());
                    Session::put('session_timeout', $user->session_timeout);
                    $this->userMgmtRepository->updateILastLogin($credentials['staff_no']);
                    
                    return 'succeed';
                }
                           
            }
            
            $user = $this->userMgmtRepository->getUserByStaffId($credentials['staff_no']);
            
            $this->userMgmtRepository->updateInvalidCountInvalidLogin($credentials['staff_no'], ($user->invalid_count_login + 1));
            return 'failed';
             
        }else{
               return 'error';
        }
    }
}

