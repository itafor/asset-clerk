<?php

namespace App\Http\Controllers\Auth;

use App\Subscription;
use App\Transaction;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Mail\EmailVerification;

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
    protected $redirectTo = '/home';

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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:8', 'max:14', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha' =>'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verify_token' => str_random(60)
        ]);
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'plan_id' => '5affebd8-a78c-47c6-998f-d20fa4f3ba0d',
            'status' => 'Successful',
            'channel' => 'Free Signup',
            'reference' => generateUUID(),
            'amount' => 0.00
        ]);
        Subscription::create([
            'user_id' => $user->id,
            'transaction_id' => $transaction->uuid,
            'start' => date('Y-m-d H:i:s'),
            // 'end' => date('Y-m-d H:i:s', strtotime('+1 months')),
            'reference' => $transaction->reference,
            'plan_id' => $transaction->plan_id,
            'status' => 'Active'
        ]);

        try{
            Mail::to($user->email)->send(new EmailVerification($user));
        }
        catch(\Exception $e){

        }
        
        return $user;
    }
}
