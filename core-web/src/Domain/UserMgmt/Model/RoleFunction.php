<?php
namespace App\Domain\UserMgmt\Model;

use Illuminate\Database\Eloquent\Model;

class RoleFunction extends Model {
    
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_function';
    
    protected $primaryKey = ['function_code', 'role_id'];
    public $incrementing = false;
    
    protected $casts = [
        'createable' => 'boolean',
        'deleteable' => 'boolean',
        'readable' => 'boolean',
        'updateable' => 'boolean',
    ];
    
}