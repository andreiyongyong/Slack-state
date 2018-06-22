<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
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
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/dashboard';

     /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts ($request) {
        $maxLoginAttempts = 2;
        $lockoutTime = 5; // 5 minutes
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
        );
    } 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * check the condition of user login 
         *  if(Auth::check())
         *  {
         *      the user is logged in....
         *  }
         */
        $this->middleware('guest', ['except' => 'logout']);
    }

    // public function username(){
    //     return 'username';
    // }

    // /**
    //  * define the guard method
    //  */
    // public function guard(){
    //     return Auth::guard('guard-name');
    // }

    // /**
    //  * handle an authentication attempt   
    //  * 
    //  * @param \Illuminate\Http\Request $request
    //  * @return Resonse
    //  */
    // public function authenticate(Request $request){
    //     $credentials = $request->only('email' , 'password');
    //     /**
    //      * compare the email in db and the email from request
    //      * if both password is same , directed view is showed with using redirect()->intended()  
    //      */
    //     if(Auth::attempt($credentials)){
    //         //Authentication passed
    //         return redirect()->intended('member-log/index');
    //     }


    // }
}
