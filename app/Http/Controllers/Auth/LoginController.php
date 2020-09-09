<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
#use App\Activity;
#use App\Http\Controllers\ActivityController;
#use App\Http\Controllers\UserController;
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


    protected $maxAttempts = 3; // default is 5
    protected $decayMinutes = 2; // default is 1
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * login method
     *
     * @var Request $request
     *
     * @return Redirect
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => __('gennix.user_not_exists')]);
        }

        if ($user && !$user->active) {
            return redirect()->back()->withErrors(['email' => __('gennix.user_not_active')]);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            activity()->disableLogging();
            $this->updateLastLogin($user);
            activity()->enableLogging();

            $user->saveActivity(__('gennix.login'), null, 'success');

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @var string $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    /**
     * Obtain the user information from GitHub.
     *
     * @var string $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => __('gennix.fail_login_social') . $provider . '.'
                ]);
        }

        $authUser = User::whereEmail($user->getEmail())->first();

        if (!$authUser) {
            return redirect()->back()->withErrors(['email' => __('gennix.user_not_exists')]);
        }

        if ($authUser) {
            if ($authUser && !$authUser->active) {
                return redirect()->back()->withErrors(['email' => __('gennix.user_not_active')]);
            }

            auth()->login($authUser);

            $this->updateLastLogin($authUser);
            $authUser->saveActivity(__('gennix.social_login') . $provider . '.', null, 'success');

            return redirect('/home');
        }
    }


    public function logout(Request $request)
    {
        $user = User::where('id', $request->user()->id)->first();
        $user->saveActivity(__('gennix.logout'), null, 'success');

        $this->guard()->logout();
        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    public function updateLastLogin($user)
    {
        $user->last_login = now();
        $user->save();
    }
}
