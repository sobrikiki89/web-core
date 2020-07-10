<?php
namespace App\Repositories\UserMgmt;

use App\Domain\UserMgmt\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssignUserRepository
{
    
    protected $User;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function gridUser(){
        
        //$listUser = $this->user->all();
        
        $listUser = DB::table('users')
        ->Join('user_role', 'user_role.user_id', '=', 'users.id')
        ->Join('role', 'role.id', '=', 'user_role.role_id')
            ->distinct()
            ->orderBy('users.id', 'asc')
            ->get(                
                array(
                    'users.id',
                    'users.staff_no',
                    'users.active',
                    'role.name as role_name'
                )
                
                );
        
        return $listUser;
    }
    
    public function all()
    {
        return $this->user->all();
    }
    
    public function find($id)
    {
        return $this->user->find($id);
    }
    
    public function getUserRole($userId){
        return DB::table('user_role')->where('user_id', $userId)->first();
    }
    
    public function update(array $attributes)
    {
        
        DB::table('category_parameter')
        ->where('id', $attributes['id'])
        ->update(
            [
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'created_at' => $attributes['created_at'],
                'updated_at' => $attributes['updated_at'],
                'staff_no' => $attributes['staff_no']
            ]
            );
    }

    public function delete($id)
    {
        return $this->user->find($id)->delete();
    }
    
    public function selectItemRole(){       
        
        $selectItems = DB::table('role')->orderBy('sort_order')->pluck('name', 'id');
        return $selectItems;
    }
    
    public function getAppFunction($userId, $functionCode){
        
        $listFunction = DB::table('users')
        ->Join('user_role', 'user_role.user_id', '=', 'users.id')
        ->Join('role', 'role.id', '=', 'user_role.role_id')
        ->Join('role_function', 'role_function.role_id', '=', 'role.id')
        ->where('users.id', $userId)
        ->where('role_function.function_code', $functionCode)
        ->take(1)
        ->get(
            array(
                'role_function.createable',
                'role_function.deleteable',
                'role_function.readable',
                'role_function.updateable',
            )
            
            );
        
        return $listFunction;
    }
    
    public function createUserRole($userId, $roleId){
        DB::table('user_role')->insert(
            [
                'user_id' => $userId,
                'role_id' => $roleId,
                'start_date' => Carbon::now()
            ]
            );
    }
    
    public function updateUserRole($userId, $roleId){
        return DB::table('user_role')
        ->where('user_id', $userId)
        ->update(
            [
                'role_id' => $roleId,
            ]
            );
    }
}