<?php
namespace App\Http\Controllers\UserMgmt;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserMgmt\UserMgmtService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\UserMgmt\AssignUserService;

class UserMgmtRequest extends FormRequest
{

    const FUNCTION_CODE = 'U02.USER';
    
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
    public function rules(UserMgmtService $userMgmtService)
    {
        
        $this->userMgmtService = $userMgmtService;
        
        $this->redirect = url()->previous() . '#formUserInfo-form';
        
        if(str_contains(Request::fullUrl(), 'update')){
            return [
                'role_id' => 'required',
                'session_timeout' => 'required',
                'invalid_count_login' => 'required',
                'max_count_login' => 'required',
            ];
        }else if(str_contains(Request::fullUrl(), 'create')){
            return [
                'role_id' => 'required',
                'session_timeout' => 'required',
                'invalid_count_login' => 'required',
                'max_count_login' => 'required',
                'staff_no' => 'required|unique:users'
            ];
        }else{
            return [
            ];
        }        
        
    }
    
    public function attributes()
    {
        return [
            'role_id' => __('messages_core_web.role'),
            'session_timeout' => __('messages_core_web.sessionTimeout'),
            'invalid_count_login' => __('messages_core_web.invalidLoginAttempt'),
            'max_count_login' => __('messages_core_web.maxInvalidLoginAttempt'),
        ];
    }
    
}

