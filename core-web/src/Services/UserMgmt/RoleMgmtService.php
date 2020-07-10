<?php
namespace App\Services\UserMgmt;

use App\Repositories\UserMgmt\RoleRepository;
use Illuminate\Http\Request;
use App\Repositories\UserMgmt\RoleFunctionRepository;
use App\Repositories\UserMgmt\AppFunctionRepository;

class RoleMgmtService
{

    public function __construct(RoleRepository $roleRepository, RoleFunctionRepository $roleFunctionRepository, AppFunctionRepository $appFunctionRepository){
        
        $this->roleRepository = $roleRepository;
        $this->roleFunctionRepository = $roleFunctionRepository;
        $this->appFunctionRepository = $appFunctionRepository;
        
    }
    
    public function gridList()
    {        
        $roleList = $this->roleRepository->gridRole();
        $arrayJson = $roleList->toArray();
        
        $metaRole = array(
            "page" => 1,
            "pages" => 1,
            "perpage" => 10,
            "total" => count($roleList),
            "sort" => "asc",
            "field" => "status");
        
        
        return array("meta" => $metaRole, "data" => $arrayJson);
    }
    
    public function gridListFunction($roleId)
    {
        $roleFunctionList = $this->roleFunctionRepository->getFunctionByRoleId($roleId);
        $arrayJson = $roleFunctionList->toArray();
        
        $metaRole = array(
            "page" => 1,
            "pages" => 1,
            "perpage" => 10,
            "total" => count($roleFunctionList),
            "sort" => "asc",
            "field" => "status");
        
        
        return array("meta" => $metaRole, "data" => $arrayJson);
        
    }
    
    public function read($id)
    {
        return $this->roleRepository->find($id);
    }
    
    public function create(Request $request){
        
        $attributes = $request->all();
        
        $this->roleRepository->create($attributes);
        
        return $this->roleRepository->getRoleByName($attributes['name']);
    }
    
    public function update(Request $request){
        
        $attributes = $request->all();
        
        $role = $this->roleRepository->update($attributes);
        
        return $role;
    }
    
    public function createRoleFunction(Request $request){
        
        $attributes = $request->all();
        
        $this->roleFunctionRepository->create($attributes);
        
        return $this->read($attributes['roleId']);
    }
    
    
    public function updateRoleFunction(Request $request){
        
        $attributes = $request->all();
        
        $this->roleFunctionRepository->update($attributes);
        
        return $this->read($attributes['role_id']);
    }
    
    public function deleteRoleFunction($roleId, $functionCode){
        
        $this->roleFunctionRepository->delete($roleId, $functionCode);
        
        return $this->read($roleId);
    }
    
    public function getSelectItemFunction(){
        $listSelectItemFunction = $this->appFunctionRepository->selectItem();
        
        return $listSelectItemFunction;
    }
}

