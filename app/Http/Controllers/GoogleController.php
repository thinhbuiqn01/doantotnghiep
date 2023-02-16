<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

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
       
            if($finduser){
       
                Auth::login($finduser);
      
                return response([
                    'status' => 200,
                    'user' => $user
                ]);
       
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_id'=> $providerId,
                    'provider'=> 'google',
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
