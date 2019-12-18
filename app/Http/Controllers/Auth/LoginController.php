<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public $maxAttempts = 3;
    public $decayMinutes = 1;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    protected function validateLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
            /*'captcha'=>'required|captcha'*/
        ]);
        /*$validator->after(function ($validator) use ($request) {
            $user = User::whereUsername($request->get($this->username()))->first();
            if (!empty($user)) {
                $passwordValidation = \Hash::check($request->get('password'), $user->password);
                if (!$passwordValidation) {
                    $validator->errors()->add('username', __('auth.failed'));
                }
            }
        });*/
        $validator->validate();
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->type == User::USER)
            return redirect('/user-panel');
        if ($user->type == User::INSPECTOR)
            return redirect('/inspector-panel');
        if ($user->type == User::CLIENT)
            return redirect('/client-panel');
        if ($user->type == User::TEAM)
            return redirect('/team-panel');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
