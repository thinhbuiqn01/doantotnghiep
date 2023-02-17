<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('provider', $googleUser->id)->first();
        try {

            $user = Socialite::driver('google')->user();
            $providerId = $user->getId();
            $finduser = User::where('provider_id', $providerId)->first();

            if ($finduser) {

                Auth::login($finduser);

                return response([
                    'status' => 200,
                    'user' => $user
                ]);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_id' => $providerId,
                    'provider' => 'google',
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);
                return response([
                    'status' => 200,
                    'user' => $user
                ]);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
