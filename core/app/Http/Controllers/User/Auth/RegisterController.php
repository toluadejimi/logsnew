<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Referre;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('registration.status')->except('registrationNotAllowed');
        $this->activeTemplate = activeTemplate();
    }

    public function showRegistrationForm(request $request)
    {


        if ($request->code != null) {

            $email = User::where('referal_code', $request->code)->increment('click_count', 1);

        }

        $pageTitle = "Register";
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $ref_code =$request->code;

        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.auth.register', compact('pageTitle', 'mobileCode','ref_code', 'countries'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $general = gs();
        $agree = 'nullable';
        if ($general->agree) {
            $agree = 'required';
        }
        $validate = Validator::make($data, [
            'email' => 'required|string|email|unique:users',
            'password' => 'required', 'confirmed',
            'username' => 'required|unique:users|min:4',
            'agree' => $agree
        ]);

        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();


        event(new Registered($user = $this->create($request->all())));


        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {



        $general = gs();


        if ($data['code'] != null) {


            $email = User::where('referal_code', $data['code'])->first()->email;
            $username = User::where('referal_code', $data['code'])->first()->username;
            $get_email = Referre::where('email_2', $data['email'])->first()->email ?? null;


            $ref = new Referre();
            $ref->email = $email;
            $ref->email_2 = trim($data['email']);
            $ref->referer = $username;
            $ref->refrere = trim($data['username']);
            $ref->save();


            User::where('email', $email)->increment('sign_up_count', 1);


        }

        //User Create
        $user = new User();
        $user->email = strtolower(trim($data['email']));
        $user->password = Hash::make($data['password']);
        $user->username = trim($data['username']);
        $user->country_code = 234;
        $user->mobile = 0;
        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => isset($data['country']) ? $data['country'] : null,
            'city' => ''
        ];
        $user->ev = $general->ev ? Status::NO : Status::YES;
        $user->sv = $general->sv ? Status::NO : Status::YES;
        $user->ts = 0;
        $user->tv = 1;
        $user->profile_complete = 1;
        $user->save();


        return $user;
    }

    public
    function checkUser(Request $request)
    {
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email', $request->email)->exists();
            $exist['type'] = 'email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile', $request->mobile)->exists();
            $exist['type'] = 'mobile';
        }
        if ($request->username) {
            $exist['data'] = User::where('username', $request->username)->exists();
            $exist['type'] = 'username';
        }
        return response($exist);
    }

    public
    function registered()
    {
        return to_route('products');
    }
}
