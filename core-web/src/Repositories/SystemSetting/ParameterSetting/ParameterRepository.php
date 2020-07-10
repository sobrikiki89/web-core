<?php
namespace App\Repositories\SystemSetting\ParameterSetting;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use App\Domain\SystemSetting\ParameterSetting\Model\Parameter;

class ParameterRepository
{
    
    protected $Parameter;
    
    public function __construct(Parameter $Parameter)
    {
        $this->Parameter = $Parameter;
    }
    
    public function gridParameter(){
        
        $listParameter = $this->Parameter->all();
        
        return $listParameter;
    }
    
    public function gridParameterByCategory($categoryParameterCode){
        
        $listParameter = DB::table('parameter')
                                    ->where('category_parameter_code', $categoryParameterCode)
                                    ->distinct()
                                    ->orderBy('sortOrder')
                                    ->get();
        
        return $listParameter;
    }
    
    public function create($attributes)
    {       
        try {
            DB::table('parameter')->insert(
                [
                    'code' => $attributes['code'],
                    'name' => $attributes['name'],
                    'sortOrder' => $attributes['sortOrder'],
                    'description' => ($attributes['description'] ? $attributes['description'] : ''),
                    'created_date' => Carbon::now(),
                    'created_by' => Auth::user()->id,
                    'updated_date' => Carbon::now(),
                    'updated_by' => Auth::user()->id,
                    'category_parameter_code' => $attributes['cpCode'],
                    'status' => $attributes['status']
                    
                ]
                );
            
            return $this->Parameter->find($attributes['code']);
        } catch(QueryException $e){
            $errorInfo = $e->errorInfo[2];
            if(strpos($errorInfo, 'duplicate key') !== false){
                return array( 'ERROR_DKEY' => __('validation.unique', ['attribute' => 'code']));
            }
        }        
    }
    
    public function all()
    {
        return $this->Parameter->all();
    }
    
    public function find($code)
    {
        return $this->Parameter->find($code);
    }
    
    public function update($attributes)
    {
        
        DB::table('parameter')
        ->where('code', $attributes['code'])
        ->update(
            [
                'name' => $attributes['name'],
                'sortOrder' => $attributes['sortOrder'],
                'description' => $attributes['description'] ? $attributes['description'] : '',
                'updated_by' => Auth::user()->id,
                'updated_date' => Carbon::now(),
                'category_parameter_code' => $attributes['cpCode'],
                'status' => $attributes['status']
            ]
            );
        return $this->Parameter->find($attributes['code']);
    }

    public function delete($code)
    {
        return $this->Parameter->find($code)->delete();
    }
    
    public function selectItemActive($catParameter){
        $selectItems = Parameter::where('category_parameter_code',$catParameter)
                                ->where('status', true)
                                ->orderBy('sortOrder')
                                ->pluck('name', 'code');
        return $selectItems;
    }
    
    public function selectItem($catParameter){
        return Parameter::pluck('code','name')
        ->where('category_parameter_code',$catParameter);
    }
}