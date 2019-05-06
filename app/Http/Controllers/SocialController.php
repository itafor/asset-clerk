<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();
        if($users){
            auth()->login($users);
            return redirect('/');
        }else{
            $name = explode(' ',  $userSocial->getName());
            $user = User::create([
                        'firstname' => $name[0],
                        'lastname' => $name[1],
                        'email' => $userSocial->getEmail(),
                        'image' => $userSocial->getAvatar(),
                        'provider_id' => $userSocial->getId(),
                        'provider' => $provider,
                        'sub_account' => 0,
                        'verified' => 'yes',
                        'role' => 'agent'
                    ]);
            auth()->login($user);
            return redirect()->route('home');
        }
    }
}
