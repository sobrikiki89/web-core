<?php
namespace App\Repositories\UserMgmt;

use Illuminate\Support\Facades\DB;
use App\Domain\UserMgmt\Model\UserRole;

class UserRoleRepository
{
    
    protected $UserRole;
    
    public function __construct(UserRole $UserRole)
    {
        $this->UserRole = $UserRole;
    }
    
    public function gridUserRole(){
        
        $listUserRole = $this->UserRole->all();
        
        return $listUserRole;
    }
    
    public function create($attributes)
    {
        DB::table('user_role')->insert(
            [
                'user_id' => $attributes['user_id'],
                'role_id' => $attributes['role_id'],
                'start_date' => $attributes['start_date'],
                'end_date' => $attributes['end_date']
            ]
            );
    }
    
    public function all()
    {
        return $this->UserRole->all();
    }
    
    public function find($id)
    {
        return $this->UserRole->find($id);
    }
    
    public function delete($id)
    {
        return $this->UserRole->find($id)->delete();
    }
}