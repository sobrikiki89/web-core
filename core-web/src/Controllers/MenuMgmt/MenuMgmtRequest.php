<?php
namespace App\Http\Controllers\MenuMgmt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\MenuMgmt\MenuMgmtService;
use App\Services\UserMgmt\AssignUserService;

class MenuMgmtRequest extends FormRequest
{

    const FUNCTION_CODE = 'M01.MENU';
    
    public function __construct()
    {}
     
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(AssignUserService $assignUserService)
    {
        
        $appFunction = $assignUserService->appFunction(Auth::user()->id, self::FUNCTION_CODE);
        
        if(str_contains(Request::fullUrl(), '/new') && !empty($appFunction[0]) && $appFunction[0]->createable)
            return true;
        else if(str_contains(Request::fullUrl(), '/edit') && !empty($appFunction[0]) && $appFunction[0]->updateable)
            return true;
        else if(str_contains(Request::fullUrl(), '/create') && !empty($appFunction[0]) && $appFunction[0]->createable)
            return true;
        else if(str_contains(Request::fullUrl(), '/read') && !empty($appFunction[0]) && $appFunction[0]->readable)
            return true;
        else if(str_contains(Request::fullUrl(), '/update') && !empty($appFunction[0]) && $appFunction[0]->updateable)
            return true;
        else if(str_contains(Request::fullUrl(), '/delete') && !empty($appFunction[0]) && $appFunction[0]->deleteable)
            return true;
        else
            return false;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(MenuMgmtService $menuMgmtService)
    {
        
        $this->menuMgmtService = $menuMgmtService;
        
        $this->redirect = url()->previous() . '#formEvent-form';
        
        if(str_contains(Request::fullUrl(), '/create')){
            $rules = [
                'name' => 'required|unique:menu_item',
                'description' => 'required',
                'sort_order' => 'required',
            ];
            
            return $rules;
            
        }else if (str_contains(Request::fullUrl(), '/update')){
  
            $rules = [
                'name' => 'required|unique:menu_item,name,'.$this->request->get('id'),
                'description' => 'required',
                'sort_order' => 'required',
            ];
            
            return $rules;
        }
        return [
        ];
        
        
    }
    
    public function attributes()
    {
        return [
            'function_code' => __('messages_core_web.function'),
        ];
    }
}

