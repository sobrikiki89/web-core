<?php
namespace App\Domain\UserMgmt\Model;

use App\Domain\Core\Model\EntityReference;


/**
 * Represents a security-related role that this user has. Specific functionality
 * requires specific roles in order for a user to be allowed access.
 */
class Role extends EntityReference {
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';
    
    protected $primaryKey = ['description'];
    
}