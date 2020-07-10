<?php

namespace App\Http\Controllers\UserMgmt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserMgmt\UserMgmtService;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    /*
     |--------------------------------------------------------------------------
     | Login Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles authenticating users for the application and
     | redirecting them to your home screen. The controller uses a trait
     | to conveniently provide its functionality to your applications.
     |
     */
    
    use AuthenticatesUsers;
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserMgmtService $userMgmtService)
    {
        //$this->middleware('guest')->except('logout');
        //$this->middleware('auth')->only('logout');
        $this->userMgmtService = $userMgmtService;
    }
    
    public function postLogin(Request $request)
    {
        request()->validate([
            'staff_no' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('staff_no', 'password');
        //Auth::loginUsingId($id);
        //if (Auth::attempt($credentials)) {
        $status = $this->userMgmtService->attemptLogin($credentials);
        if ($status == 'succeed') {
            // Authentication passed...
            return redirect()->intended('home');
        }else if($status == 'failed'){
            // // Authentication failed : Username or Password wrong
            $this->incrementLoginAttempts($request);            
            return $this->sendFailedLoginResponse($request);
        }else if($status == 'invalidCount'){
                throw ValidationException::withMessages([
                    $this->username() => [trans('messages_core_web.accountLocked')],
                ]);            
        }else if($status == 'inactiveAcc'){
            throw ValidationException::withMessages([
                $this->username() => [trans('messages_core_web.acountDisabled')],
            ]);
        }else if($status == 'invalidCount'){
            throw ValidationException::withMessages([
                $this->username() => [trans('messages_core_web.accountLocked')],
            ]);
        }else{
            // General Error : failed to access auth server
            return $this->sendErrorLoginResponse($request);
        }
        
        /* 
        return Redirect::to("login")->withSuccess('Oppes! You have entered invalid credentials'); 
        */
    }
}