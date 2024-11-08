<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\ProductQuantity;

class OrderController extends Controller
{
    public function index(){
        $orderData = Order::orderBy('id', 'desc')->get();
        return view('backend.order.index',compact('orderData'));
    }

    //order details.......
    public function orderDetails($id){

        $orderData = Order::where('id',$id)->first();
        $orderProductData = OrderProduct::where('order_id',$id)->get();
        $addressData = Address::where('id',$orderData->address_id)->first();
        return view('backend.order.orderDetails',compact('orderData','orderProductData','addressData'));

    }

    //order accept ......
    public function orderAccept($id){

        $date = Carbon::today()->addDays(4)->toDateString();
        $deliveryTime = date('d-M-Y', strtotime($date));

        $data = Order::where('id',$id)->first();
        $data->delivery_time = $deliveryTime;
        $data->order_status = 'accept';
        $data->delivery_status = 'proccess';
        $data->save();  

        //push notification send...........
        $customerData = Customer::where('id',$data->customer_id)->first();
        $deliveryTime = $data->delivery_time;
        $sendNotification = $this->orderAcceptSendPushNotification($customerData,$deliveryTime);

        return redirect()->back()->with('message','Successfully order accept and delivery proccessing');
    }

     //order canceled ......
    public function orderCanceled($id){

        $data = Order::where('id',$id)->first();
        $data->order_status = 'canceled';
        $data->save();

        //push notification send...........
        $customerData = Customer::where('id',$data->customer_id)->first();
        $sendNotification = $this->orderCanceledSendPushNotification($customerData);

        return redirect()->back()->with('error','Order Canceled');
    }


     //delivery process ......
     public function deliveryProccess($id){

        $data = Order::where('id',$id)->first();
        $data->delivery_status = 'proccess';
        $data->save();

        return redirect()->back()->with('message','Delivery Processing');
    }


    //delivery out For Delivery ......
    public function outForDelivery($id){

        $data = Order::where('id',$id)->first();
        $data->delivery_status = 'out for delivery';
        $data->save();

        //push notification send...........
        $customerData = Customer::where('id',$data->customer_id)->first();
        $sendNotification = $this->orderOutForDeliverySendPushNotification($customerData);

        return redirect()->back()->with('message','Out For Delivery');
    }


    //delivery rejected ......
    public function deliveryRejected($id){

        $data = Order::where('id',$id)->first();
        $data->delivery_status = 'rejected';
        $data->save();
        
        //push notification send...........
        $customerData = Customer::where('id',$data->customer_id)->first();
        $sendNotification = $this->orderRejectedSendPushNotification($customerData);

        return redirect()->back()->with('error','Delivery Rejected');
    }

    //delivery success ......
    public function deliverySuccess($id){

        $data = Order::where('id',$id)->first();
        $data->delivery_status = 'success';
        $data->save();

         //push notification send...........
         $customerData = Customer::where('id',$data->customer_id)->first();
         $sendNotification = $this->orderSuccessSendPushNotification($customerData,$data->order_unique_id);

        return redirect()->back()->with('message','Delivery Processing');
    }



/* ------------- push notification message ------------ */

    //send push notification order accept.............
    public function orderAcceptSendPushNotification($customerData,$date){

        $text = "Hello  ".$customerData->first_name." your order is now being processed for delivery.";
        $content = array(
            "en" => $text
        );
        $name = array(
            "en" => 'SYCL'
        );
        $email = $customerData->email;
        $fields = array(
            'app_id' => "88a20577-4547-4833-9ec8-4bde5d6d2e6e",
            'include_external_user_ids' => array($email),
            'contents' => $content,
            'name' => $name
        );
                
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic YTg5ZWRhMDEtMTUwOC00YWU2LTk5MzMtNjhhNmM5Njg4N2Q3'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
    }


    //send push notification order cancel.............
    public function orderCanceledSendPushNotification($customerData){

        $text = "Hello your order with SYCL has been CANCELED. Please retain cancellation information for your records.";
        $content = array(
            "en" => $text
        );
        $name = array(
            "en" => 'SYCL'
        );
        $email = $customerData->email;
        $fields = array(
            'app_id' => "88a20577-4547-4833-9ec8-4bde5d6d2e6e",
            'include_external_user_ids' => array($email),
            'contents' => $content,
            'name' => $name
        );
                
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic YTg5ZWRhMDEtMTUwOC00YWU2LTk5MzMtNjhhNmM5Njg4N2Q3'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
    }


    //send push notification order out for delivery.............
    public function orderOutForDeliverySendPushNotification($customerData){

        $text = "Hello ".$customerData->first_name." your order has now been shipped out for delivery.";

        $content = array(
            "en" => $text
        );
        $name = array(
            "en" => 'SYCL'
        );
        $email = $customerData->email;
        $fields = array(
            'app_id' => "88a20577-4547-4833-9ec8-4bde5d6d2e6e",
            'include_external_user_ids' => array($email),
            'contents' => $content,
            'name' => $name
        );
                
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic YTg5ZWRhMDEtMTUwOC00YWU2LTk5MzMtNjhhNmM5Njg4N2Q3'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
    }


    //send push notification order rejected.............
    public function orderRejectedSendPushNotification($customerData){

        $text = "The order has now been rejected at your request. Thank you for shopping with SYCL";

        $content = array(
            "en" => $text
        );
        $name = array(
            "en" => 'SYCL'
        );
        $email = $customerData->email;
        $fields = array(
            'app_id' => "88a20577-4547-4833-9ec8-4bde5d6d2e6e",
            'include_external_user_ids' => array($email),
            'contents' => $content,
            'name' => $name
        );
                
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic YTg5ZWRhMDEtMTUwOC00YWU2LTk5MzMtNjhhNmM5Njg4N2Q3'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
    }


    //send push notification order success.............
    public function orderSuccessSendPushNotification($customerData,$orderId){

        $text = "Hello ".$customerData->first_name." your order with order number ".$orderId." has now been delivered.";

        $content = array(
            "en" => $text
        );
        $name = array(
            "en" => 'SYCL'
        );
        $email = $customerData->email;
        $fields = array(
            'app_id' => "88a20577-4547-4833-9ec8-4bde5d6d2e6e",
            'include_external_user_ids' => array($email),
            'contents' => $content,
            'name' => $name
        );
                
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic YTg5ZWRhMDEtMTUwOC00YWU2LTk5MzMtNjhhNmM5Njg4N2Q3'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
    }

}
