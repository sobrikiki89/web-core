<?php
namespace App\Domain\SystemSetting\ParameterSetting\Model;

use App\Domain\Core\Model\EntityCodeHistory;

class CategoryParameter extends EntityCodeHistory
{    
    
    protected $table = 'category_parameter';
    
    protected $fillable = ['description'];  
    
}