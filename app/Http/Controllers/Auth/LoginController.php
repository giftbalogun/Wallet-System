<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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

    protected function credentials(Request $request)
    {
        return [
            'username' => $request->{$this->username()},
            'password' => $request->password,
            'status' => 1,
        ];
    }

    public function username()
    {
        return 'username';
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status != 1) {
            $errors = [
                $this->username() => _lang('Your account is not active !'),
            ];
            Auth::logout();
            return back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($errors);
        } elseif (auth()->user()->utype == 1) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        $user = \App\Models\User::where(
            $this->username(),
            $request->{$this->username()}
        )->first();

        if (
            $user &&
            \Hash::check($request->password, $user->password) &&
            $user->status != 1
        ) {
            $errors = [
                $this->username() => 'Your account is not active !',
            ];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
}
