<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrivacyPolicy;
use App\Category;
use App\User;
use App\Item;
use App\Addons;
use App\Ratting;
use App\Order;
use App\Promocode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function policy() {
        $getprivacypolicy = PrivacyPolicy::where('id', '1')->first();
        return view('privacy-policy', compact('getprivacypolicy'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $getcategory = Category::all();
        $getitems = Item::all();
        $addons = Addons::all();
        $getreview = Ratting::all();
        $getorders = Order::all();
        $order_total = Order::sum('order_total');
        $order_tax = Order::sum('tax_amount');
        $getpromocode = Promocode::all();
        $getusers = User::Where('type', '=' , '2')->get();
        $driver = User::Where('type', '=' , '3')->get();
        $todayorders = Order::with('users')->where('created_at','LIKE','%' .date("Y-m-d") . '%')->get();
        return view('home',compact('getcategory','getitems','addons','getusers','driver','getreview','getorders','order_total','order_tax','getpromocode','todayorders'));
    }
}
