<?php
namespace App\Repositories\UserMgmt;

use Illuminate\Support\Facades\DB;
use App\Domain\UserMgmt\Model\Role;

class RoleRepository
{
    
    protected $role;
    
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
    
    public function gridRole(){
        
        $listRole = DB::table('role')->orderBy('sort_order')->get();
        
        return $listRole;
    }
    
    public function create($attributes)
    {
        return DB::table('role')->insert(
            [
                'name' => $attributes['name'],
                'sort_order' => $attributes['sort_order'],
                'description' => $attributes['description'],
            ]
            );
    }
    
    public function all()
    {
        return $this->role->all();
    }
    
    public function find($id)
    {
        return DB::table('role')->find($id);
    }
    
    public function delete($id)
    {
        return $this->role->find($id)->delete();
    }
    
    public function update($attributes){
        DB::table('role')
            ->where('id', $attributes['id'])
            ->update([
                'name' => $attributes['name'],
                'sort_order' => $attributes['sort_order'],
                'description' => $attributes['description'],
            ]);
            
        return $this->find($attributes['id']);
    }
    
    public function getRoleByName($name){
        return DB::table('role')->where('name', $name)->first();
    }
}