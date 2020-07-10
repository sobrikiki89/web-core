<?php
namespace App\Domain\UserMgmt\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {
    
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_role';
    
    protected $primaryKey = ['user_id', 'role_id'];
    public $incrementing = false;
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    public function getUserId(){
        return $this->belomgTo('App\Domain\UserMgmt\Model\User');
    }
    
    public function getRoleId(){
        return $this->belomgTo('App\Domain\UserMgmt\Model\Role');
    }
    
}