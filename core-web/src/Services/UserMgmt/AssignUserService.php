<?php

namespace App\Services\UserMgmt;

use Illuminate\Http\Request;
use App\Repositories\UserMgmt\UserMgmtRepository;
use App\Repositories\UserMgmt\AssignUserRepository;

class AssignUserService
{
    public function __construct(AssignUserRepository $assignUserRepository, UserMgmtRepository $userMgmtRepository)
    {
        $this->assignUserRepository = $assignUserRepository;
        $this->userMgmtRepository = $userMgmtRepository;
    }
    
    public function index()
    {
        return $this->assignUserRepository->all();
    }
    
    public function gridList(){
        
        $assignUserList = $this->assignUserRepository->gridUser();
        $arrayJson = $assignUserList->toArray();
        
        for($i=0; $i<count($arrayJson); $i++){
            $infoStaff = $this->userMgmtRepository->staffInfomation($arrayJson[$i]->staff_no);
            $arrayJson[$i] = array_merge(json_decode(json_encode($arrayJson[$i]), true), $infoStaff, ['no' => ($i + 1)]);
        }
        
        $metaAssignUser = array(
            "page" => 1,
            "pages" => 1,
            "perpage" => 10,
            "total" => count($assignUserList),
            "sort" => "asc",
            "field" => "status");
        
        
        return array("meta" => $metaAssignUser, "data" => $arrayJson);
    }
    
    public function create(Request $request)
    {
        
        $attributes = $request->all();
        
        $infoStaff = $this->userMgmtRepository->staffInfomation($attributes['staff_no']);
        
        $attributes = array_merge($attributes, $infoStaff);
        
        $user = $this->userMgmtRepository->createUser($attributes);
        
        return $this->assignUserRepository->createUserRole($user[0]->id, $attributes['role_id']);
    }
    
    public function read($id)
    {
        $user = $this->assignUserRepository->find($id);
        $userRole = $this->assignUserRepository->getUserRole($user->id);
        return array_merge($user->toArray(), json_decode(json_encode($userRole), true));
    }
    
    public function update(Request $request)
    {
        
        $attributes = $request->all();
        $this->userMgmtRepository->updateUser($attributes);
        return  $this->assignUserRepository->updateUserRole($this->userMgmtRepository->getUserByStaffId($attributes['staff_no'])->id, $attributes['role_id']);
    }
    
    public function delete($code)
    {
        return $this->assignUserRepository->delete($code);
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
    
}