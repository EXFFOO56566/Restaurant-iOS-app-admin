<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use validate;
use Hash;
use Session;
use App\User;
use App\Category;
use App\Item;
use App\Addons;
use App\Ratting;
use App\Order;
use App\Promocode;

class AdminController extends Controller {
    public function login() {
        return view('login');
    }

    public function home() {
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
        $getdriver = User::where('type','3')->get();
        return view('home',compact('getcategory','getitems','addons','getusers','driver','getreview','getorders','order_total','order_tax','getpromocode','todayorders','getdriver'));
    }

    public function getorder() {

        $todayorders = Order::with('users')
        ->where('created_at','LIKE','%' .date("Y-m-d") . '%')
        ->where('is_notification','=','1')
        ->count();
        return json_encode($todayorders);
    }

    public function clearnotification() {
        // dd('ss');
        $update = Order::query()->update(["is_notification" => "2"]);

        return json_encode($update);
    }

    public function changePassword(request $request)
    {
        $validation = \Validator::make($request->all(), [
            'oldpassword'=>'required|min:6',
            'newpassword'=>'required|min:6',
            'confirmpassword'=>'required_with:newpassword|same:newpassword|min:6',
        ],[
            'oldpassword.required'=>'Old Password is required',
            'newpassword.required'=>'New Password is required',
            'confirmpassword.required'=>'Confirm Password is required'
        ]);
         
        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else if($request['oldpassword']==$request['newpassword'])
        {
            $error_array[]='Old and new password must be different';
        }
        else
        {        
            if(\Hash::check($request->oldpassword,Auth::user()->password)){
                $data['password'] = Hash::make($request->newpassword);
                User::where('id', Auth::user()->id)->update($data);
                Session::flash('message', '<div class="alert alert-success"><strong>Success!</strong> Password has been changed.!! </div>');
               
            }else{
                $error_array[]="Old Password is not match.";
            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        return json_encode($output);  

    }

    public function settings(request $request)
    {
        $validation = \Validator::make($request->all(), [
            'tax'=>'required',
            'delivery_charge'=>'required'
        ]);
        
        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            if($request->is_open == "false") {
                $is_open = "2";
            } else {
                $is_open = "1";
            }
            $setting = User::where('id', Auth::user()->id)->update( array('tax'=>$request->tax, 'delivery_charge'=>$request->delivery_charge, 'lat'=>$request->lat, 'lang'=>$request->lang, 'is_open'=>$is_open) );

            if ($setting) {
                Session::flash('message', '<div class="alert alert-success"><strong>Success!</strong> Data updated.!! </div>');
            } else {
                $error_array[]="Please try again";
            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        return json_encode($output);  

    }

    public function logout(Request $request) {
        Auth::logout();
        return Redirect::to('admin/');
    }
}
