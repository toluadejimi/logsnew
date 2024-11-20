<?php

namespace App\Http\Controllers\Gateway;

use App\Models\Bought;
use App\Models\Referre;
use App\Models\User;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\Product;
use App\Constants\Status;
use App\Models\OrderItem;
use App\Lib\FormProcessor;
use App\Models\CouponCode;
use App\Models\VCard;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function depositInsert(Request $request)
    {


        if ($request->gateway == "card") {


            $card = VCard::where('user_id', Auth::id())->first()->card_no;
            $databody = array(
                "card_no" => $card,
                "amount" => $request->amount,
                "key" => env('WEBKEY'),
                "email" => Auth::user()->email,
                "site" => "LogmarketPlace",

            );

            $post_data = json_encode($databody);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://sprintpay.online/api/charge-card',
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

                $data = new Deposit();
                $data->user_id = Auth::id();
                $data->order_id = "SPC".date('ymshis');
                $data->method_code = "251";
                $data->method_currency = "NGN";
                $data->amount = $request->amount;
                $data->charge = 0;
                $data->rate = 0;
                $data->final_amo = $request->amount;
                $data->btc_amo = 0;
                $data->btc_wallet = "";
                $data->trx = getTrx();
                $data->save();
                User::where('id', Auth::id())->increment('balance', $request->amount);



            }else{
                return redirect('user/profile')->with('error',"$message");

            }





            $unsoldProductDetails = $product->unsoldProductDetails;

            for ($i = 0; $i < $qty; $i++) {
                if (@!$unsoldProductDetails[$i]) {
                    continue;
                }
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->product_id = $product->id;
                $item->product_detail_id = $unsoldProductDetails[$i]->id;
                $item->price = $product->price;
                $item->save();
            }

            session()->put('Track', $data->trx);
            return to_route('user.deposit.confirm');
        }


        if ($request->payment == "wallet") {

            $last_order = Order::latest()->where('user_id', Auth::id())->first()->created_at ?? null;

            if($last_order != null){

                $createdAt = strtotime($last_order);
                $currentTime = time();
                $timeDifference = $currentTime - $createdAt;

                if ($timeDifference < 50) {

                    $notify = "Please wait for 10sec and try again";
                    return redirect('user/orders')->with('error', $notify);


                }

            }





            $qty = $request->qty;

            $product = Product::active()->whereHas('category', function ($category) {
                return $category->active();
            })->findOrFail($request->id);


            if ($product->in_stock < $qty) {
                $notify = "Not enough stock available. Only {$product->in_stock} quantity left";
                return redirect('/items')->with('error', $notify);
            }

            $amount = ($product->price * $qty);


            $balance = Auth::user()->balance ?? null;
            if ($balance < $amount) {
                $notify = "Insufficient Funds, Fund your wallet";
                return redirect('/items')->with('error', $notify);
            }



            $final_amo = $amount;

            if ($request->coupon_code != null) {

                $ck = CouponCode::where('coupon_code', $request->coupon_code)->first() ?? null;
                if ($ck == null) {
                    return back()->with('error', 'Coupon does not exist');
                }

                if ($ck->status == 2) {
                    return back()->with('error', 'Coupon is not valid');
                }



                $percentage = $ck->amount / 100;
                $coupon_amount = $percentage * $final_amo;

                $charge_amount = $final_amo - $coupon_amount;



            } else {
                $charge_amount = $final_amo;
            }


            User::where('id', Auth::id())->decrement('balance', $charge_amount);

            $order = new Order();
            $order->user_id = Auth::id();
            $order->total_amount = $charge_amount;
            $order->status = 1;
            $order->save();

            $unsoldProductDetails = $product->unsoldProductDetails;



            $amount1 = 3 / 100;
            $amount2 = $amount1 * $product->price;
            $percent = round($amount2, 2);


            $ck_ref = Referre::where('refrere', Auth::user()->username)->first() ?? null;
            if($ck_ref != null){
                $reff = Referre::where('refrere', Auth::user()->username)->first();
                $user_id = User::where('email', $reff->email)->first()->id;
                User::where('username', $reff->referer)->increment('ref_wallet', $percent);

                $depo = new Deposit();
                $depo->user_id = $user_id;
                $depo->order_id = 0;
                $depo->method_code = 6000;
                $depo->amount = $percent;
                $depo->status = 1;
                $depo->save();

            }

            //dd($percent, $ck_ref, $reff);


            for ($i = 0; $i < $qty; $i++) {
                if (@!$unsoldProductDetails[$i]) {
                    continue;
                }
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->product_id = $product->id;
                $item->product_detail_id = $unsoldProductDetails[$i]->id;
                $item->price = $product->price;
                $item->save();
            }


            $br = new Bought();
            $br->user_name = Auth::user()->username;
            $br->qty = $qty;
            $br->item = $product->name;
            $br->amount = $amount;
            $br->save();


            $message = "Log Market Place |" .  Auth::user()->email . "| just bought | $qty | $order->id  | " . number_format($charge_amount, 2) . "\n\n IP ====> " . $request->ip();
            send_notification_2($message);



            $notify = "Order Purchased Successfully";
            return redirect('user/orders')->with('message', $notify);


        }

        if ($request->payment == "enkpay") {


            if ($request->amount < 100) {
                $notify[] = ['error', "Amount can not be less than 100"];
                return back()->withNotify($notify);
            }


            if ($request->amount > 100000) {
                $notify[] = ['error', "Amount can not be more than 100,000"];
                return back()->withNotify($notify);
            }


            $data = new Deposit();
            $data->user_id = Auth::id();
            //$data->order_id = $order->id;
            $data->method_code = $request->gateway;
            $data->method_currency = "NGN";
            $data->amount = $request->amount;
            $data->charge = 0;
            $data->rate = 0;
            $data->final_amo = $request->amount;
            $data->btc_amo = 0;
            $data->btc_wallet = "";
            $data->trx = getTrx();
            $data->save();

            $message = "Log Market Place |" .  Auth::user()->email . "| Wants to fund using ENKPAY  | " . number_format($request->amount, 2) . "\n\n IP ====> " . $request->ip();
            send_notification_2($message);
            send_notification_4($message);



            session()->put('Track', $data->trx);
            return to_route('user.deposit.confirm');
        }



        if ($request->gateway == 250) {

            $qty = $request->qty;

            $product = Product::active()->whereHas('category', function ($category) {
                return $category->active();
            })->findOrFail($request->id);

            if ($product->in_stock < $qty) {
                $notify[] = ['error', "Not enough stock available. Only {$product->in_stock} quantity left"];
                return back()->withNotify($notify);
            }

            $amount = ($product->price * $qty);

            $user = auth()->user();
            $gate = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', Status::ENABLE);
            })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();
            if (!$gate) {
                $notify[] = ['error', 'Invalid gateway'];
                return back()->withNotify($notify);
            }

            if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
                $notify[] = ['error', 'Please follow deposit limit'];
                return back()->withNotify($notify);
            }

            $charge = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
            $payable = $amount + $charge;
            $final_amo = $payable * $gate->rate;

            $order = new Order();
            $order->user_id = $user->id;
            $order->total_amount = $amount;
            $order->save();

            $data = new Deposit();
            $data->user_id = $user->id;
            $data->order_id = $order->id;
            $data->method_code = $gate->method_code;
            $data->method_currency = strtoupper($gate->currency);
            $data->amount = $amount;
            $data->charge = $charge;
            $data->rate = $gate->rate;
            $data->final_amo = $final_amo;
            $data->btc_amo = 0;
            $data->btc_wallet = "";
            $data->trx = getTrx();
            $data->save();

            $unsoldProductDetails = $product->unsoldProductDetails;



            for ($i = 0; $i < $qty; $i++) {
                if (@!$unsoldProductDetails[$i]) {
                    continue;
                }
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->product_id = $product->id;
                $item->product_detail_id = $unsoldProductDetails[$i]->id;
                $item->price = $product->price;
                $item->save();
            }

            session()->put('Track', $data->trx);
            return to_route('user.deposit.confirm');
        }







        $request->validate([
            'gateway' => 'required',
            'currency' => 'required',
            'id' => 'required',
            'qty' => 'required|integer|gt:0',
        ]);

        $qty = $request->qty;


        $product = Product::active()->whereHas('category', function ($category) {
            return $category->active();
        })->findOrFail($request->id);

        if ($product->in_stock < $qty) {
            $notify[] = ['error', "Not enough stock available. Only {$product->in_stock} quantity left"];
            return back()->withNotify($notify);
        }

        $amount = ($product->price * $qty);

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable = $amount + $charge;
        $final_amo = $payable * $gate->rate;

        $order = new Order();
        $order->user_id = $user->id;
        $order->total_amount = $amount;
        $order->save();

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->order_id = $order->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->save();

        $unsoldProductDetails = $product->unsoldProductDetails;

        for ($i = 0; $i < $qty; $i++) {
            if (@!$unsoldProductDetails[$i]) {
                continue;
            }
            $item = new OrderItem();
            $item->order_id = $order->id;
            $item->product_id = $product->id;
            $item->product_detail_id = $unsoldProductDetails[$i]->id;
            $item->price = $product->price;
            $item->save();
        }

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function depositConfirm(request $request)
    {


        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }


        // if($deposit->method_code == 250){

        // }

        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {

        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            $user = User::find($deposit->user_id);
            $email = User::where('id', $deposit->user_id)->first()->email;
            User::where('id', $deposit->user_id)->increment('balance', $deposit->amount);

            $message = "Log Market Place |" .  $email . "|" . number_format($deposit->amount, 2) .  "| has been manually funded by Admin";
            send_notification_2($message);
            send_notification_3($message);
            send_notification_4($message);
            send_notification($message);
            send_notification_3($message);




            if (!$isManual) {
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Payment successful via ' . $deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name' => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount' => showAmount($deposit->final_amo),
                'amount' => showAmount($deposit->amount),
                'charge' => showAmount($deposit->charge),
                'rate' => showAmount($deposit->rate),
                'trx' => $deposit->trx,
            ]);
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Payment Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');

        $data = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;


        if ($request->receipt == null) {
            return back()->with('error', "Payment receipt is required");
        }

        $file = $request->file('receipt');
        $receipt_fileName = date("ymis") . $file->getClientOriginalName();
        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = getFilePath('verify') . '/' . $directory;
        $request->receipt->move($path, $receipt_fileName);
        $url = url('') . "/" . $path . "/" . $receipt_fileName;


        Deposit::where('trx', $track)->update([
            'status' => Status::PAYMENT_PENDING,
            'url' => $url,
        ]);



        $email = User::where('id', $data->user->id)->first()->email;

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Payment request from ' . $data->user->username;
        $adminNotification->click_url = $url;
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => showAmount($data->final_amo),
            'amount' => showAmount($data->amount),
            'charge' => showAmount($data->charge),
            'rate' => showAmount($data->rate),
            'trx' => $data->trx
        ]);


        $message = "Log Market Place |" .  $email . "| wants to fund using manual " . number_format($data->amount, 2) .  "| check admin to confirm";
        send_notification_2($message);
        send_notification_4($message);
        send_notification($message);

        $notify = "You have payment request is successful, you will be credited soon";
        return redirect('/user/deposit/new')->with('message', $notify);
    }



}
