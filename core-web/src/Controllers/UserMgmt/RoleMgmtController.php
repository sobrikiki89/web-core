<?php
namespace App\Http\Controllers\UserMgmt;

use App\Http\Controllers\Controller;
use App\Services\UserMgmt\RoleMgmtService;

class RoleMgmtController extends Controller
{

    private RoleMgmtService $roleMgmtService;
    

    public function __construct(RoleMgmtService $roleMgmtService)
    {
        $this->setRoleMgmtService($roleMgmtService);
    }
    
    public function index()
    {
        return view('secured.module.userMgmt.role.list');
    }
    
    public function gridList(){
        return response()->json($this->roleMgmtService->gridList());
    }
    
    public function read($id, RoleMgmtRequest $request){
        
        $role = $this->getRoleMgmtService()->read($id);        
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        
        return view('secured.module.userMgmt.role.edit', compact('role', 'selectItemFunction'));
        
    }
    
    public function new(RoleMgmtRequest $request){
        
        return view('secured.module.userMgmt.role.new');
    }
    
    public function create(RoleMgmtRequest $request){
        
        $role = $this->roleMgmtService->create($request);
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        
        return view('secured.module.userMgmt.role.edit', compact('role', 'selectItemFunction'));
    }
    
    public function update(RoleMgmtRequest $request){
        
        $role = $this->roleMgmtService->update($request);
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        
        return view('secured.module.userMgmt.role.edit', compact('role', 'selectItemFunction'));
    }
    
    public function gridListFunction($roleId){
        return response()->json($this->roleMgmtService->gridListFunction($roleId));
    }
    
    public function createRoleFunction(RoleMgmtRequest $request){
        
        $this->roleMgmtService->createRoleFunction($request);
        return response()->json(array('msg' => 'success'));
    }
    
    public function updateRoleFunction(RoleMgmtRequest $request){
        
        $role = $this->roleMgmtService->updateRoleFunction($request);
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        
        return view('secured.module.userMgmt.role.edit', compact('role', 'selectItemFunction'));
    }
    
    public function deleteRoleFunction($roleId, $functionCode, RoleMgmtRequest $request){
        
        $role = $this->roleMgmtService->deleteRoleFunction($roleId, $functionCode);
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        
        return view('secured.module.userMgmt.role.edit', compact('role', 'selectItemFunction'));
    }
    
    /**
     * @return mixed
     */
    public function getRoleMgmtService()
    {
        return $this->roleMgmtService;
    }
    
    /**
     * @param mixed $roleMgmtService
     */
    public function setRoleMgmtService($roleMgmtService)
    {
        $this->roleMgmtService = $roleMgmtService;
    }
    
}

