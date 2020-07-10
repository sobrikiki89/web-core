<?php
namespace App\Domain\UserMgmt\Model;

use Illuminate\Database\Eloquent\Model;

class AppFunction extends Model {
    
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_function';
    
    protected $primaryKey = ['code'];
    public $incrementing = false;
    
    
    protected $fillable = ['path','name','description'];
    
}