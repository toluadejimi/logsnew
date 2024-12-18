<?php

namespace App\Http\Controllers\User\Auth;

use Status;
use App\Models\Product;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $username;


    public function __construct()
    {

        parent::__construct();
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    public function showLoginForm(Request $request)
    {
        session()->forget('redirect_after_login');

        $redirect = $request->redirect;
        if($redirect){
            try{
                $headers = get_headers($redirect);
                $status = substr($headers[0], 9, 3);
                if($status == 200){
                    session()->put('redirect_after_login', $redirect);
                }
            }catch(\Exception $e){}
        }

        $pageTitle = "Login";
        return view($this->activeTemplate . 'user.auth.login', compact('pageTitle'));
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function findUsername()
    {
        $login = request()->input('username');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

    }

    public function logout()
    {

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $notify[] = ['success', 'You have been logged out.'];
        return to_route('user.login')->withNotify($notify);
    }





    public function authenticated(Request $request, $user)
    {
        $user->tv = $user->ts == Status::VERIFIED ? Status::UNVERIFIED : Status::VERIFIED;
        $user->save();
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip',$ip)->first();
        $userLogin = new UserLogin();
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',',$info['long']);
            $userLogin->latitude =  @implode(',',$info['lat']);
            $userLogin->city =  @implode(',',$info['city']);
            $userLogin->country_code = @implode(',',$info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();

        $redirectUrl = session()->get('redirect_after_login');
        if($redirectUrl){
            session()->forget('redirect_after_login');
            return redirect()->to($redirectUrl);
        }

        return redirect('products');
    }


    public function item_view(Request $request, $id)
    {


        $user = Auth::id();
        if ($user == null) {
            return view('user/login');
        }

        $pageTitle = 'Product Details';
        $product = Product::active()->whereHas('category', function($category){
            return $category->active();
        })->findOrFail($id);

        $relatedProducts = Product::active()->whereHas('category', function($category){
            return $category->active();
        })->where('category_id',$product->category_id)->orderBy('id','desc')->where('id','!=',$product->id)->limit(5)->get();

        return view($this->activeTemplate . 'product_details', compact('pageTitle', 'product','relatedProducts'));

        return view('item-view', compact('title', 'icon', 'inst', 'description', 'item_id', 'stock', 'amount', 'user'));
    }


}
