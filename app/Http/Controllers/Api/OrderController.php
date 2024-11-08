<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Customer;
use App\Models\Product;
use Auth;
use App\Models\ProductColorManage;
use App\Models\Address;
use App\Helpers\PushNotificationMessage;
use App\Models\ProductQuantity;

class OrderController extends Controller
{
    
    //create access token ............
    public function createAccessToken(Request $request){
        
        $customer_id= Auth::user()->id;
        $orderId = "SYCL-ORDER@".random_int(1000000, 9999999);
        $cartData = Cart::where('customer_id',$customer_id)->get();
        
        if($cartData != null){
            $order = new Order();
            $order->order_unique_id = $orderId;
            $order->customer_id = $customer_id;
            $order->address_id = $request->address_id;
            $order->subtotal_amount = $request->subTotal;
            $order->shipping_fee = $request->shippingFee;
            $order->total_amount =  $request->total;
            $order->delivery_time = 'pending';
            $order->payment_status = 'pending';
            $order->save();

            foreach($cartData as $cart){
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $cart->product_id;
                $orderProduct->color = $cart->color;
                $orderProduct->size = $cart->size;
                $orderProduct->qty = $cart->qty;
                $orderProduct->price = $cart->price;
                $orderProduct->save();
            }
        }

        $totalAmount = $request->total;

        $customerData = Customer::where('id',$customer_id)->first();
        $url = "https://api.paystack.co/transaction/initialize";

        $fields = [
            'email' => $customerData->email,
            'amount' => $totalAmount,
        ];

        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_test_5221a4c37fb5f55837cd0f40f929cbae24b8164c",
            "Cache-Control: no-cache",
        ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        $result = curl_exec($ch);
        $decodeData = json_decode($result);

        $access_code = $decodeData->data->access_code;

        $order = Order::where('id',$order->id)->first();
        $order->access_code = $access_code;
        $order->save();

        if(!empty($access_code)){
            return response()->json([
                'message'   =>  'success',
                'access_code'   =>  $access_code,
                'orderId'   =>  $order->order_unique_id,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }


    //verify payment ............
    public function verifyTransaction(Request $request){
        
        $orderId = $request->orderId;
        $checkOrder = Order::where('order_unique_id',$orderId)->first();
        
        if($checkOrder != null){
            
         if($checkOrder->access_code == $request->access_code){
            
            $reference = $request->reference;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer sk_test_5221a4c37fb5f55837cd0f40f929cbae24b8164c",
                "Cache-Control: no-cache",
                ),
            ));
            $response = curl_exec($curl);
            $decodeResponse = json_decode($response);

            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                $error =  $err;
                return response()->json([
                    'message'   =>  $error
                ], 500);

            }else {
                $data =  $decodeResponse;

                if($data->message == 'Verification successful'){
                    $orderData = Order::where('order_unique_id',$request->orderId)->first();
                    $orderData->payment_status = 'success';
                    $orderData->save();

                    $customer_id= Auth::user()->id;
                    $customerData = Customer::where('id',$customer_id)->first();
                    $cartProductDelete = Cart::where('customer_id',$customer_id)->delete();

                    $orderProduct = OrderProduct::where('order_id',$orderData->id)->get();

                    foreach($orderProduct as $order){
                        $productQuantity = ProductQuantity::where('product_id',$order->product_id)->where('color_name',$order->color)->where('size_name',$order->size)->first();
                        $productQuantity->quantity -= $order->qty;
                        $productQuantity->save();
                    }

                    $sendNotification = $this->orderCompleteSendPushNotification($customerData);

                    return response()->json([
                        'message'   =>  'success',
                        'first_name' => $customerData->first_name,
                        'last_name' => $customerData->last_name,
                        'email' => $customerData->email,
                        'order_id' => $orderData->order_unique_id,
                        'total_amount' => $orderData->total_amount,
                    ], 201);

                }else{
                    $orderData = Order::where('order_unique_id',$request->orderId)->first();
                    $orderData->payment_status = 'canceled';
                    $orderData->save();

                    return response()->json([
                        'data'   =>  $decodeResponse,
                    ], 201);

                }

            }

         }else{
            return response()->json([
				'message'   =>  'Access Token not match.'
			], 500);
         }
            
        }else{
            return response()->json([
				'message'   =>  'Order not exist.'
			], 500);
        }
        
    }


    //send push notification order complete.............
    public function orderCompleteSendPushNotification($customerData){

            $text = "Hello ".$customerData->first_name." Thank you for shopping with SYCL. Your payment has been confirmed.";

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


    //get order customer id wise.........
    public function getOrder(){
        $customer_id= Auth::user()->id;
        $orderData = Order::where('customer_id',$customer_id)->get();

        if(!empty($orderData)){
            return response()->json([
                'message'   =>  'success',
                'orderData'   =>  $orderData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }
    
    //get order product order wise ..........
    public function getOrderProductOrderWise($orderId){

        $orderData = Order::where('order_unique_id',$orderId)->first();
        $addressData = Address::where('id',$orderData->address_id)->first();
        $order = OrderProduct::where('order_id',$orderData->id)->get();

        $orderProductData = [];
        foreach($order as $item){
            if($item != null){
                $productData = Product::where('id',$item->product_id)->first();
                $productColorData = ProductColorManage::where('product_id',$item->product_id)->where('color_name',$item->color)->whereJsonContains('product_size',$item->size)->first();

                $orderProductData[] = array(
                    'product_name' => $productData->product_name,
                    'color' => $item->color,
                    'size' => $item->size,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'image' => $productColorData->product_images,
                );
            }
        }

        if(!empty($orderProductData)){
            return response()->json([
                'message'   =>  'success',
                'orderProductData'   =>  $orderProductData,
                'addressData'   =>  $addressData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }

    }

    
    //payemnt cancel...............
    public function paymentCancel($OrderId){

        $customer_id= Auth::user()->id;
        $data = Order::where('customer_id',$customer_id)->where('order_unique_id',$OrderId)->first();
        if($data->payment_status == 'success'){
            return response()->json([
                'message'   =>  'This Order Payment AllReady Success.'
            ], 500);
        }else{

            $data->payment_status = 'canceled';
            $data->save();

            $customerData = Customer::where('id',$customer_id)->first();
            $sendNotification = $this->orderCancelSendPushNotification($customerData);

            return response()->json([
                'message'   =>  'Successfully payment cancel',
            ], 201);
        }
    }

     //send push notification order cancel.............
     public function orderCancelSendPushNotification($customerData){
        $text = "Oh no, your payment for this order failed. Please verify your card information is correct and try again.";
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
