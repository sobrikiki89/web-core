<?php
namespace App\Domain\Core\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class EntityHistory extends Model
{    
    
    protected $fillable = ['created_by', 'updated_by'];
    
    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
    ];
    
    public function getCreatedBy(){
        return $this->belomgTo('App\Domain\UserMgmt\Model\User');
    }
    
    public function getUpdatedBy(){
        return $this->belomgTo('App\Domain\UserMgmt\Model\User');
    }
    
    
    public function setCreatedByAttribute()
    {
        $this->attributes['created_by'] = Auth::user()->id;
    }
    
    public function setUpdatedByAttribute()
    {
        $this->attributes['updated_by'] =  Auth::user()->id;
    }
}