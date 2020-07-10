<?php
namespace App\Domain\Core\Model;

use Illuminate\Database\Eloquent\Model;

class EntityCode extends Model
{

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'code';
    public $incrementing = false;
    
    protected $fillable = ['name', 'sortOrder'];
    
}