<?php
namespace App\Domain\SystemSetting\ParameterSetting\Model;

use App\Domain\Core\Model\EntityCodeHistory;

class Parameter extends EntityCodeHistory
{    
    
    protected $table = 'parameter';
    
    protected $fillable = ['description', 'status', 'category_parameter_code'];
    
    public function getCategoryParameterCode(){
        return $this->belomgTo('App\Domain\SystemSetting\ParameterSetting\Model\CategoryParameter');
    }
    
}