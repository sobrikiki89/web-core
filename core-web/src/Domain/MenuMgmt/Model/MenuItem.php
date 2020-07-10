<?php
namespace App\Domain\MenuMgmt\Model;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{    
    
    protected $table = 'menu_item';
    
    protected $fillable = ['name','description','sort_order','function_code','parent_id'];
    
    protected $casts = [
        'parent_flag' => 'boolean',
    ];
    
    public function getfunctionCode(){
        return $this->belomgTo('App\Domain\UserMgmt\Model\AppFunction');
    }
    
    public function getParentId(){
        return $this->belomgTo('App\Domain\MenuMgmt\Model\MenuItem');
    }
    
}