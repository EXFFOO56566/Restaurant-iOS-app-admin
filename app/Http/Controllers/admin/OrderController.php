<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Item;
use App\User;
use App\OrderDetails;

use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getorders = Order::with('users')->select('order.*','users.name')->leftJoin('users', 'order.driver_id', '=', 'users.id')->get();
        $getdriver = User::where('type','3')->get();
        // dd($getorders);
        return view('orders',compact('getorders','getdriver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice(Request $request)
    {
        $getusers = Order::with('users')->where('order.id', $request->id)->get()->first();
        $getorders=OrderDetails::with('itemimage')->select('order_details.id','order_details.qty','order_details.price as total_price','item.id','item.item_name','item.item_price','order_details.item_id')
        ->join('item','order_details.item_id','=','item.id')
        ->join('order','order_details.order_id','=','order.id')
        ->where('order_details.order_id',$request->id)->get();

        // $getorders = OrderDetails::with('items')->where('order_details.item_id', $request->id)->get();
        // dd($getusers['users']);
        return view('invoice',compact('getorders','getusers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $UpdateDetails = Order::where('id', $request->id)
                    ->update(['status' => $request->status]);

        $userdetails = Order::where('id', $request->id)->first();

        //Notification
        $getalluses=User::select('users.token')->where('users.id',$userdetails->user_id)
        ->get()->first();

        $title = "Order";

        if ($request->status == "2") {
            $body = 'Your Order '.$userdetails->order_number.' is Ready';
        } else {
            $body = 'Your Order '.$userdetails->order_number.' is Delivered';
        }
        
        $google_api_key = "AAAABdWnJCg:APA91bHZIrdC8Vre9lRlW89DNVYlwtvafqMf2yfgS8sdNMcnT7q1xJnVmCKu3vAP51QsrVwKzAzjk_7dZ3UC1Nc7J0-gf8CMjiaHseoUcwdp7WpS-Bl6l__NhGOrfn975IMPT7gPpPLL"; 
        
        $registrationIds = $getalluses->token;
        #prep the bundle
        $msg = array
            (
            'body'  => $body,
            'title' => $title,
            'sound' => 1/*Default sound*/
            );
            
        $fields = array
            (
            'to'            => $registrationIds,
            'notification'  => $msg
            );

        $headers = array
            (
            'Authorization: key=' . $google_api_key,
            'Content-Type: application/json'
            );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        
        $result = curl_exec ( $ch );
        // dd($result);
        curl_close ( $ch );

        if ($UpdateDetails) {
            return 2;
        } else {
            return 0;
        }
    }

    public function assign(Request $request)
    {
        $UpdateDetails = Order::where('id', $request->bookId)
                    ->update(['driver_id' => $request->driver_id,'status' => '3']);

        $userdetails = Order::where('id', $request->bookId)->first();

        $google_api_key = "AAAABdWnJCg:APA91bHZIrdC8Vre9lRlW89DNVYlwtvafqMf2yfgS8sdNMcnT7q1xJnVmCKu3vAP51QsrVwKzAzjk_7dZ3UC1Nc7J0-gf8CMjiaHseoUcwdp7WpS-Bl6l__NhGOrfn975IMPT7gPpPLL"; 

        $title = "Order";

        if ($userdetails->driver_id) {

            $gettoken=User::select('users.token')->where('users.id',$userdetails->driver_id)
            ->get()->first();

            $body = 'New Order '.$userdetails->order_number.' assigned to you';

            $registrationIds = $gettoken->token;
            #prep the bundle
            $msg = array
                (
                'body'  => $body,
                'title' => $title,
                'sound' => 1/*Default sound*/
                );
                
            $fields = array
                (
                'to'            => $registrationIds,
                'notification'  => $msg
                );

            $headers = array
                (
                'Authorization: key=' . $google_api_key,
                'Content-Type: application/json'
                );
            #Send Reponse To FireBase Server
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec ( $ch );
            curl_close ( $ch );
        }

        if ($userdetails->user_id) {
            $gettoken=User::select('users.token')->where('users.id',$userdetails->user_id)
            ->get()->first();

            $body = 'Your Order '.$userdetails->order_number.' is on the way';

            $registrationIds = $gettoken->token;
            #prep the bundle
            $msg = array
                (
                'body'  => $body,
                'title' => $title,
                'sound' => 1/*Default sound*/
                );
                
            $fields = array
                (
                'to'            => $registrationIds,
                'notification'  => $msg
                );

            $headers = array
                (
                'Authorization: key=' . $google_api_key,
                'Content-Type: application/json'
                );
            #Send Reponse To FireBase Server
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

            $result = curl_exec ( $ch );
            curl_close ( $ch );
        }

        if ($UpdateDetails) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $order=Order::where('id', $request->id)->delete();
        $delete=OrderDetails::where('order_id', $request->id)->delete();
        if ($order) {
            return 1;
        } else {
            return 0;
        }
    }
}
