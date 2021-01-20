<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use App\Http\Controllers\Auth\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Providers\RouteServiceProvider;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:sub_user')->except('logout');
    }

    // public function login(\Illuminate\Http\Request $request) {
    //     $this->validateLogin($request);
    
    //     // If the class is using the ThrottlesLogins trait, we can automatically throttle
    //     // the login attempts for this application. We'll key this by the username and
    //     // the IP address of the client making these requests into this application.
    //     if ($this->hasTooManyLoginAttempts($request)) {
    //         $this->fireLockoutEvent($request);
    //         return $this->sendLockoutResponse($request);
    //     }
    
    //     // This section is the only change
    //     if ($this->guard()->validate($this->credentials($request))) {
    //         $user = $this->guard()->getLastAttempted();
    
    //         // Make sure the user is enabled
    //         if (($user->status || $user->status === null) && $this->attemptLogin($request)) {
    //             // Send the normal successful login response
    //             return $this->sendLoginResponse($request);
    //         } else {
    //             // Increment the failed login attempts and redirect back to the
    //             // login form with an error message.
    //             $this->incrementLoginAttempts($request);
    //             return redirect()
    //                 ->back()
    //                 ->withInput($request->only($this->username(), 'remember'))
    //                 ->withErrors(['email' => 'You must be enabled to login, please contact the admin.']);
    //         }
    //     }
    
    //     // If the login attempt was unsuccessful we will increment the number of attempts
    //     // to login and redirect the user back to the login form. Of course, when this
    //     // user surpasses their maximum number of attempts they will get locked out.
    //     $this->incrementLoginAttempts($request);
    
    //     return $this->sendFailedLoginResponse($request);
    // }

    public function login(Request $request)
    {   
        $input = $request->all();
   
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Login Admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))
        ) {

            return redirect()->intended('/admin/home');
        }
        
        // Login user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            // dd('YO');
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        // Login SubUsers
        if (Auth::guard('sub_user')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->get('remember'))) {
            
            // dd(Auth::guard('sub_user')->user());
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        if (Auth::guard('sub_user')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 0], $request->get('remember'))) {
            
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'You are not enabled. Please contanct the admin']);;
        }

        return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Invalid details.']);;
          
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    

    protected function guard(){
        return Auth::guard('admin');
    }
    // protected function authenticated($request, $user)
    // {
    //     if($user->role_id === 3) {
    //         return redirect()->intended('/admin/home');
    //     }

    //     return redirect()->intended('/home');
    // }

        /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        
      Auth::guard('admin')->logout();
      Auth::guard('sub_user')->logout();
      Auth::guard('web')->logout();
        
      $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
