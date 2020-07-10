<?php
namespace App\Domain\Core\Model;

use Illuminate\Database\Eloquent\Model;

class EntityReference extends Model
{
    
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    //protected $primaryKey = 'id';
    
    protected $fillable = ['name', 'sort_order'];
    
}