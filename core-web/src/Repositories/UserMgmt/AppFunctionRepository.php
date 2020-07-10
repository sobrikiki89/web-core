<?php
namespace App\Repositories\UserMgmt;

use App\Domain\UserMgmt\Model\AppFunction;

class AppFunctionRepository
{
    
    protected $AppFunction;
    
    public function __construct(AppFunction $AppFunction)
    {
        $this->AppFunction = $AppFunction;
    }
    
    public function gridAppFunction(){
        
        $listAppFunction = $this->AppFunction->all();
        
        return $listAppFunction;
    }
    
    public function create($attributes)
    {
        return $this->AppFunction->create($attributes);
    }
    
    public function all()
    {
        return $this->AppFunction->all();
    }
    
    public function find($id)
    {
        return $this->AppFunction->find($id);
    }
    
    public function delete($id)
    {
        return $this->AppFunction->find($id)->delete();
    }
    
    public function selectItem(){
        return AppFunction::pluck('name', 'code');
    }
}