<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\VCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{


    public function profile_view()
    {
        $pageTitle = "Profile";
        $user = auth()->user();
        $card = VCard::where('user_id', Auth::id())->count() ?? null;
        $v_card = VCard::where('user_id', Auth::id())->first() ?? null;
        $orders = Order::where('user_id', Auth::id())->where('status', 1)->count();
        $spent = Order::where('user_id', Auth::id())->where('status', 1)->sum('total_amount');

        $deposit = auth()->user();
        return view($this->activeTemplate. 'user.profile', compact('pageTitle','user', 'spent', 'orders', 'card', 'v_card'));

    }
    public function profile()
    {

        $pageTitle = "Profile Setting";
        $user = auth()->user();

        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            return redirect('/')->with('message','Password changes successfully');

        } else {
            $notify = "The password doesn\'t match!";
            return back()->with('error', $notify);
        }
    }

    public function link_card(request $request)
    {

        $databody = array(
            "card_no" => $request->card_no,
            "cvv" => $request->cvv,
            "site" => "LogmarketPlace",

        );

        $post_data = json_encode($databody);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sprintpay.online/api/card',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));
        $var = curl_exec($curl);
        curl_close($curl);
        $var = json_decode($var);
        $status = $var->status ?? null;
        $message = $var->message ?? null;


        if($status == "success"){
            $vc = new VCard();
            $vc->user_id = Auth::user()->id;
            $vc->card_no = $request->card_no;
            $vc->cvv = $request->cvv;
            $vc->save();
            return redirect('user/profile')->with('message','Card has been successfully linked');
        }else{
            return redirect('user/profile')->with('error',"$message");

        }



    }

}
