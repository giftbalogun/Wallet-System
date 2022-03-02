<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
#use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    #protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => 'required|string|max:255|unique:users',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'utype' => 0,
            'status' => 1,
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilio_sid = getenv('TWILIO_SID');
        $twilio_verify_sid = getenv('TWILIO_VERIFY_SID');
        $twilio = new Client($twilio_sid, $token);

        $verification = $twilio->messages->create(
            $data['phone'], // to
            [
                'body' => $data['verification_code'],
                'messagingServiceSid' => 'MGfe1f8bffc580a285204433a0cd6b0211',
            ]
        );

        #$verification = $twilio->verify->v2
        #   ->services($twilio_verify_sid)
        #  ->verificationChecks->create($data['verification_code'], [
        #     'to' => $data['phone'],
        #]);

        if ($verification->valid) {
            $user = tap(User::where('phone', $data['phone']))->update([
                'status' => 1,
            ]);
            /* Authenticate user */
            //Auth::login($user->first());
            return redirect()
                ->route('home')
                ->with(['message' => 'Phone number verified']);
        }
        return back()->with([
            'phone' => $data['phone'],
            'error' => 'Invalid verification code entered!',
        ]);
    }
}
