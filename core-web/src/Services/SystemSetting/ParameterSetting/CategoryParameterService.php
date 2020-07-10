<?php

namespace App\Services\SystemSetting\ParameterSetting;

use Illuminate\Http\Request;
use App\Repositories\SystemSetting\ParameterSetting\CategoryParameterRepository;
use App\Repositories\SystemSetting\ParameterSetting\ParameterRepository;

class CategoryParameterService
{
    public function __construct(CategoryParameterRepository $categoryParameterRepository, ParameterRepository $parameterRepository)
    {
        $this->categoryParameterRepository = $categoryParameterRepository ;
        
        $this->parameterRepository = $parameterRepository ;
    }
    
    public function index()
    {
        return $this->categoryParameterRepository->all();
    }
    
    public function gridList(){
        
        $categoryParameterList = $this->categoryParameterRepository->gridCategoryParameter();
        $arrayJson = $categoryParameterList->toArray();
        
        $metaEvent = array(
            "page" => 1,
            "pages" => 1,
            "perpage" => 10,
            "total" => count($categoryParameterList),
            "sort" => "asc",
            "field" => "status");
        
        
        return array("meta" => $metaEvent, "data" => $arrayJson);
    }
    
    public function gridListParameter($code){
        
        $categoryParameterList = $this->parameterRepository->gridParameterByCategory($code);
        $arrayJson = $categoryParameterList->toArray();
        
        $metaEvent = array(
            "page" => 1,
            "pages" => 1,
            "perpage" => 10,
            "total" => count($categoryParameterList),
            "sort" => "asc",
            "field" => "status");
        
        
        return array("meta" => $metaEvent, "data" => $arrayJson);
    }
    
    public function create(Request $request)
    {
        
        $attributes = $request->all();

        return $this->categoryParameterRepository->create($attributes);
    }
    
    
    public function createParameter(Request $request)
    {
        
        $attributes = $request->all();
        
        return $this->parameterRepository->create($attributes);
    }
    
    public function updateParameter(Request $request)
    {
        
        $attributes = $request->all();
        
        return $this->parameterRepository->update($attributes);
    }
    
    public function read($code)
    {
        return $this->categoryParameterRepository->find($code);
    }
    
    public function update(Request $request)
    {
        
        $attributes = $request->all();

        //Update Status categoryParameter and return the record
        return  $this->categoryParameterRepository->update($attributes);
    }
    
    public function delete($code)
    {
        return $this->categoryParameterRepository->delete($code);
    }
}