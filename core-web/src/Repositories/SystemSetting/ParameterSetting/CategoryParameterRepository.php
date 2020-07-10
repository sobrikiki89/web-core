<?php
namespace App\Repositories\SystemSetting\ParameterSetting;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use App\Domain\SystemSetting\ParameterSetting\Model\CategoryParameter;

class CategoryParameterRepository
{
    
    protected $CategoryParameter;
    
    public function __construct(CategoryParameter $CategoryParameter)
    {
        $this->CategoryParameter = $CategoryParameter;
    }
    
    public function gridCategoryParameter(){
        
        $listCategoryParameter = $this->CategoryParameter->all();
        
        return $listCategoryParameter;
    }
    
    public function create($attributes)
    {
        
        try {
            DB::table('category_parameter')->insert(
                [
                    'code' => $attributes['code'],
                    'name' => $attributes['name'],
                    'sortOrder' => $attributes['sortOrder'],
                    'description' => ($attributes['description'] ? $attributes['description'] : ''),
                    'created_date' => Carbon::now(),
                    'created_by' => Auth::user()->id,
                    'updated_date' => Carbon::now(),
                    'updated_by' => Auth::user()->id,
                    
                ]
                );
            
            return $this->CategoryParameter->find($attributes['code']);
        }catch(QueryException $e){
            $errorInfo = $e->errorInfo[2];
            if(strpos($errorInfo, 'duplicate key') !== false){
                return array( 'ERROR_DKEY' => __('validation.unique', ['attribute' => 'code']));
            }
        }
    }
    
    public function all()
    {
        return $this->CategoryParameter->all();
    }
    
    public function find($code)
    {
        return $this->CategoryParameter->find($code);
    }
    
    public function update(array $attributes)
    {
        
        DB::table('category_parameter')
        ->where('code', $attributes['code'])
        ->update(
            [
                'name' => $attributes['name'],
                'sortOrder' => $attributes['sortOrder'],
                'description' => ($attributes['description'] ? $attributes['description'] : ''),
                'updated_by' => Auth::user()->id,
                'updated_date' => Carbon::now()
            ]
            );
        return $this->CategoryParameter->find($attributes['code']);
    }

    public function delete($code)
    {
        return $this->CategoryParameter->find($code)->delete();
    }
}