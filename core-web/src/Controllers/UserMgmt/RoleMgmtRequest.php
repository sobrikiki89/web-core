<?php
namespace App\Http\Controllers\UserMgmt;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserMgmt\AssignUserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\UserMgmt\RoleMgmtService;
use Illuminate\Validation\Rule;

class RoleMgmtRequest extends FormRequest
{
    const FUNCTION_CODE = 'U01.ROLE';
    
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
    public function rules(RoleMgmtService $roleMgmtService)
    {
        
        $this->roleMgmtService = $roleMgmtService;
        
        $this->redirect = url()->previous() . '#formEvent-form';
        
        if(str_contains(Request::fullUrl(), '/role/create')){
                $rules = [
                    'name' => 'required|unique:role',
                    'description' => 'required',
                    'sort_order' => 'required',
                ];
                
                return $rules;
                
        }else if (str_contains(Request::fullUrl(), '/role/update')){
            $rules = [
                'name' => 'required|unique:role,name,'.$this->request->get('id'),
                'description' => 'required',
                'sort_order' => 'required',
            ];
            
            return $rules;
        }else if(str_contains(Request::fullUrl(), '/role/delete')){
            $rules = [
                //'nama' => 'required'
            ];
            
            return $rules;
        }else if(str_contains(Request::fullUrl(), '/roleFunction/create')){
            $rules = [
                        'function_code' => ['required',
                                            Rule::unique('role_function')->where(function ($query) {
                                                return $query->where('role_id', $this->request->get('roleId'));
                                                }),
                      ]
            ];
            
            return $rules;
            
        }
        /*
        else if(str_contains(Request::fullUrl(), '/roleFunction/update')){
            $rules = [
                        'function_code' => [    'required',
                                                Rule::unique('role_function')->whereNot('function_code', $this->request->get('function_code'))->where(function ($query) {
                                                    return $query->whe ->where('role_id', $this->request->get('role_id'));
                                                }),
                                            ]
                    ];
            
            return $rules;
        }
        */
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

