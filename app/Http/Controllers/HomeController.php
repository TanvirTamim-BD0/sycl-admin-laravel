<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\MiddleCategory;
use App\Models\BottomBannner;
use App\Models\SquareBanner;
use App\Models\TopBanner;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\BannerCategory;
use Auth;
use Carbon\Carbon;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $primeCategory = Category::count();
        $subCategory = SubCategory::count();
        $middleCategory = MiddleCategory::count();
        $product = Product::count();
        $topBanner = TopBanner::count();
        $squareBanner = SquareBanner::count();
        $bottomBanner = BottomBannner::count();
        $customer = Customer::count();
        $bannerCategory = BannerCategory::count();
        $orderSuccess = Order::where('delivery_status','success')->count();
        $orderPending = Order::where('order_status','pending')->count();
        $orderCancel = Order::where('order_status','canceled')->count();
        $user = User::count();

        //today sellig amount ............
        $todayDate = Carbon::now()->today()->toDateString();
        $todayOrder = Order::where('created_at',$todayDate)->where('delivery_status','success')->pluck('id');
        $todayOrderProduct = OrderProduct::whereIn('order_id',$todayOrder)->get();

        $todaySellingPrice = 0;
        foreach($todayOrderProduct as $data){
            if($data != null){
                $todaySellingPrice += $data->price;
            }
        }

        //total selling amount ...........
        $totalOrder = Order::where('delivery_status','success')->pluck('id');
        $totalOrderProduct = OrderProduct::whereIn('order_id',$totalOrder)->get();

        $totalSellingPrice = 0;
        foreach($totalOrderProduct as $data){
            if($data != null){
                $totalSellingPrice += $data->price;
            }
        }

        $orderData = Order::where('payment_status','success')->where('order_status','pending')->get();
        return view('backend.dashboard',compact('primeCategory','subCategory','middleCategory','product','topBanner','squareBanner','bottomBanner','customer','orderSuccess','orderCancel','todaySellingPrice','totalSellingPrice','orderPending','bannerCategory','user','orderData'));
    }
}
