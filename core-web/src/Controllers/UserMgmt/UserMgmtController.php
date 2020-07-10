<?php
namespace App\Http\Controllers\UserMgmt;

use App\Services\UserMgmt\AssignUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserMgmtController extends Controller
{
    
    private AssignUserService $assignUserService;
    
    
    public function __construct(AssignUserService $assignUserService){
        
        $this->assignUserService = $assignUserService;
    }
    
    public function index()
    {
        return view('secured.module.userMgmt.user.list');
    }
    
    
    public function gridList(){
        return response()->json($this->assignUserService->gridList());
    }
    
    public function new(UserMgmtRequest $request){
        
        $selectItemRole = $this->assignUserService->getSelectItemRole();
        
        return view('secured.module.userMgmt.user.new', ['selectItemRole' => $selectItemRole]);
    }
    
    public function create(UserMgmtRequest $request){
        $this->assignUserService->create($request);
        $users = $this->assignUserService->index();
        $selectItemRole = $this->assignUserService->getSelectItemRole();
        
        return view('secured.module.userMgmt.user.list', compact('users', 'selectItemRole'));
    }
    
    public function read(UserMgmtRequest $request, $id){
        $user = $this->assignUserService->read($id);
        $selectItemRole = $this->assignUserService->getSelectItemRole();
        
        return view('secured.module.userMgmt.user.edit', compact('user', 'selectItemRole'));
    }
    
    public function update(UserMgmtRequest $request)
    {
        
        $user = $this->assignUserService->update($request);
        
        $selectItemRole = $this->assignUserService->getSelectItemRole();
        
        return view('secured.module.userMgmt.user.list', compact('user', 'selectItemRole'));
    }
    
    
    public function infoStaff(Request $request){
        
        $data = $this->assignUserService->getStaffInfo($request);
        
        if (array_key_exists('ERROR',$data)){
            return response()->json(['errors' => $data], 400);
        }
        
        return response()->json(['data' => $data], 200);
        
    }
    
    /**
     * @return \App\Services\UserMgmt\AssignUserService
     */
    public function getAssignUserService()
    {
        return $this->assignUserService;
    }

    /**
     * @param \App\Services\UserMgmt\AssignUserService $assignUserService
     */
    public function setAssignUserService($assignUserService)
    {
        $this->assignUserService = $assignUserService;
    }
}

