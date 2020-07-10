<?php
namespace App\Repositories\UserMgmt;


use App\Domain\UserMgmt\Model\RoleFunction;
use Illuminate\Support\Facades\DB;

class RoleFunctionRepository
{
    
    protected $RoleFunction;
    
    public function __construct(RoleFunction $RoleFunction)
    {
        $this->RoleFunction = $RoleFunction;
    }
    
    public function gridRoleFunction(){
        
        $listRoleFunction = $this->RoleFunction->all();
        
        return $listRoleFunction;
    }
    
    public function getFunctionByRoleId($roleId){
        $listFunction = DB::table('role_function')
                            ->join('app_function', 'app_function.code', 'role_function.function_code')
                            ->where('role_id', $roleId)
                            ->orderBy('app_function.code')
                            ->get(
                                array(                                    
                                    'role_function.function_code',
                                    'role_function.role_id',
                                    'app_function.name',
                                    'role_function.createable',
                                    'role_function.deleteable',
                                    'role_function.readable',
                                    'role_function.updateable',
                                )
                                );
        return $listFunction;
    }
    
    public function create($attributes)
    {
        DB::table('role_function')->insert(
            [
                'role_id' => $attributes['roleId'],
                'function_code' => $attributes['function_code'],
                'createable' => isset($attributes['createable']) ? $attributes['createable'] : false,
                'deleteable' => isset($attributes['deleteable']) ? $attributes['deleteable'] : false,
                'readable' => isset($attributes['readable']) ? $attributes['readable'] : false,
                'updateable' => isset($attributes['updateable']) ? $attributes['updateable'] : false,
                
            ]);
    }
    
    public function update($attributes){
        
        return DB::table('role_function')
        ->where([
            'role_id' => $attributes['role_id'],
            'function_code' => $attributes['function_code']
        ])
        ->update(
            [
                'createable' => isset($attributes['createable']) ? $attributes['createable'] : false,
                'deleteable' => isset($attributes['deleteable']) ? $attributes['deleteable'] : false,
                'readable' => isset($attributes['readable']) ? $attributes['readable'] : false,
                'updateable' => isset($attributes['updateable']) ? $attributes['updateable'] : false,
                
            ]
            );
        
    }
    
    public function all()
    {
        return $this->RoleFunction->all();
    }
    
    public function find($id)
    {
        return $this->RoleFunction->find($id);
    }
    
    public function delete($roleId, $functionCode)
    {
        return DB::table('role_function')->where('role_id' , '=', $roleId)->where('function_code' , '=', $functionCode)->delete();
    }
}