<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Bought;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\GatewayCurrency;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Jorenvh\Share\Share;


class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'user.welcome', compact('pageTitle', 'sections'));
    }

    public function resolve_support()
    {

        return view($this->activeTemplate . 'resolve-support');
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }


    public function contact()
    {

        $auth = Auth::check();
        if ($auth == false) {
            return redirect('/user/login');
        }

        $pageTitle = "Contact Us";
        $user = auth()->user();
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->first();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'user', 'sections'));
    }


    public function deposit_now(Request $request)
    {

        if ($request->vendor == 'log') {
            $usr = User::where('email', $request->email)->first() ?? null;
            if ($usr == null) {
                return back()->with('error', "Customer not registred on Log Market Place");
            }

            User::where('email', $request->email)->increment('balance', $request->amount);

            return back()->with('message', "$usr->username | has been successfully funded | NGN $request->amount  | new balance is |NGN" . $usr->balance);

            $message = $usr->usernmae . " | has been successfully funded | NGN" . $request->amount . " on Log Market Place by support | new balance is |NGN" . $usr->balance;
            send_notification($message);

        }


    }




    //Route::any('fund',  'SiteController@fund_now')->name('fund');




    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public
    function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public
    function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        $notify[] = ['info', 'Admin can translate every word from the admin panel.'];
        $notify[] = ['warning', 'All Language keywords are not implemented in the demo version.'];
        return back()->withNotify($notify);
    }

    public
    function blog()
    {
        $pageTitle = 'Blogs';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->orderBy('id', 'DESC')->first();
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(12);
        return view($this->activeTemplate . 'blogs', compact('pageTitle', 'sections', 'blogs'));
    }

    public
    function blogDetails($slug, $id)
    {
        $blog = Frontend::where('data_keys', 'blog.element')->findOrFail($id);
        $pageTitle = 'Blog Details';
        $customPageTitle = $blog->data_values->title;
        $latestBlogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->limit(5)->get();

        $seoContents['keywords'] = [];
        $seoContents['social_title'] = $blog->data_values->title;
        $seoContents['description'] = strLimit(strip_tags($blog->data_values->description), 150);
        $seoContents['social_description'] = strLimit(strip_tags($blog->data_values->description), 150);
        $seoContents['image'] = getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '820x550');
        $seoContents['image_size'] = '820x550';
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'latestBlogs', 'customPageTitle', 'seoContents'));
    }


    public
    function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public
    function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public
    function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }


    }

    public
    function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }


    public function front(){

        return view($this->activeTemplate . 'front');
    }





    public
    function products()
    {



        $request = request();
        $request->validate([
            'search' => 'nullable|regex:/^[\w-]*$/'
        ]);

        $categories = Category::active()
            ->whereHas('products', function ($products) {
                return $products->active()->searchable(['name', 'description', 'category:name']);
            })
            ->with(['products' => function ($products) {
                return $products->active()->orderBy('id', 'DESC');
            }, 'products.productDetails']);


        $pageTitle = 'Products ';

        $get_wallet = Auth::user()->wallet ?? null;
        if ($get_wallet == null) {
            $wallet = null;
        } else {
            $wallet = Auth::user()->wallet;
        }
        $categories = $categories->orderBy('name')->paginate(getPaginate());


        $hour = now()->hour;

        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 18) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }

        $greetings = $greeting;


        $bought_qty = Bought::count();

        $bought = Bought::latest()->paginate('20');



        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'products')->first();
        $gateway_currency = GatewayCurrency::all();


        return view($this->activeTemplate . 'products', compact('pageTitle', 'bought_qty','bought', 'gateway_currency', 'greetings', 'categories', 'sections', 'wallet'));
    }


    public
    function search(Request $request)
    {

        $cat = Category::where('name', 'LIKE', "%$request->keyword%")->first() ?? null;

        if ($cat == null) {

            return back()->with('error', "No category found");

        }

        $title = Category::where('id', $cat->id)->first()->title;

        $products = Product::where('category_id', $cat->id)->get();

        $user = Auth::id() ?? null;


        return view('template/basic/category_products', compact('title', 'user', 'products'));


    }

    public
    function categoryProducts($category = null, $id = 0)
    {


        $chk = Auth::check();
        if ($chk == false) {
            return redirect('user/login');
        }


        $category = Category::active()->findOrFail($id);
        $pageTitle = $category->name;

        $products = Product::active()
            ->where('category_id', $category->id)
            ->searchable(['name', 'description'])
            ->with('productDetails')
            ->orderBy('id', 'DESC')
            ->paginate(getPaginate());

        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'products')->first();

        return view($this->activeTemplate . 'category_products', compact('pageTitle', 'category', 'products', 'sections'));
    }

    public
    function productDetails(Request $request)
    {

        $pageTitle = 'Product Details';
        $product = Product::active()->whereHas('category', function ($category) {
            return $category->active();
        })->findOrFail($request->id);

        $relatedProducts = Product::active()->whereHas('category', function ($category) {
            return $category->active();
        })->where('category_id', $product->category_id)->orderBy('id', 'desc')->where('id', '!=', $product->id)->limit(5)->get();


        $url = url('');


        $shareComponent = (new \Jorenvh\Share\Share)->page(
            "$url/open/details/$request->id",
            "$product->name",
        )
            ->facebook()
            ->twitter()
            ->telegram()
            ->whatsapp();


        $bought_qty = Bought::count();

        $bought = Bought::latest()->paginate('20');


        return view($this->activeTemplate . 'product_details', compact('pageTitle','bought_qty','bought', 'product', 'shareComponent', 'relatedProducts'));
    }

    public
    function subscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:subscribers,email'
        ]);

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $newSubscriber = new Subscriber();
        $newSubscriber->email = $request->email;
        $newSubscriber->save();

        return response()->json(['success' => true, 'message' => 'Thank you, we will notice you our latest news']);
    }

    public
    function e_check(request $request)
    {


        $get_user = User::where('email', $request->email)->first() ?? null;

        if ($get_user == null) {

            return response()->json([
                'status' => false,
                'message' => 'No user found, please check email and try again',
            ]);
        }


        return response()->json([
            'status' => true,
            'username' => $get_user->username,
        ]);
    }


    public
    function e_fund(request $request)
    {

        $get_user = User::where('email', $request->email)->first() ?? null;

        if ($get_user == null) {

            return response()->json([
                'status' => false,
                'message' => 'No user found, please check email and try again',
            ]);
        }

            User::where('email', $request->email)->increment('balance', $request->amount) ?? null;

        $amount = number_format($request->amount, 2);

        $get_depo = Deposit::where('trx', $request->order_id)->first() ?? null;
        if ($get_depo == null){
            $trx = new Deposit();
            $trx->trx = $request->order_id;
            $trx->status = 1;
            $trx->user_id = $get_user->id;
            $trx->amount = $request->amount;
            $trx->method_code = 250;
            $trx->save();
        }else{
            Deposit::where('trx', $request->order_id)->update(['status'=> 1]);
        }




        return response()->json([
            'status' => true,
            'message' => "NGN $amount has been successfully added to your wallet",
        ]);

    }


}
