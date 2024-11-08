<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cart;
use App\Models\ProductColorManage;

class CartController extends Controller
{
    
    //get cart ..............
    public function getCart()
    {   
        $customer_id= Auth::user()->id;
        $cartData = Cart::where('customer_id',$customer_id)->with('productData')->with('colorData')->orderBy('id','desc')->get();

        if(!empty($cartData)){
            return response()->json([
                'message'   =>  'success',
                'cartData'   =>  $cartData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }
    }


    //add cart ..............
    public function addCart(Request $request){

        $request->validate([
            'product_id'=> 'required',
            'color'=> 'required',
            'size'=> 'required',
            'qty'=> 'required',
            'price'=> 'required',
        ]);

        $data = $request->all();
        $data['customer_id'] = Auth::user()->id;
        $customerId = Auth::user()->id;

        $check = Cart::where('customer_id',$customerId)->where('product_id',$request->product_id)->first();
        
        if($check == null){

            if(Cart::create($data)){
                return response()->json([
                    'message'   =>  'success',
                ], 201);

            }else{
                return response()->json([
                    'message'   =>  'Something wrong.'
                ], 500);
            }
        
        }else{
            return response()->json([
                'message'   =>  'Product AllReady Added Cart !!.'
            ], 500);
        }

    }

     //update cart ..............
     public function updateCart(Request $request ,$id){

        $request->validate([
            'product_id'=> 'required',
            'qty'=> 'required',
            'color'=> 'required',
            'size'=> 'required',
        ]);

        $data = $request->all();

        $productData = ProductColorManage::where('product_id',$request->product_id)->where('color_name',$request->color)->first();
        $price = $productData->product_price * $request->qty;

        $cart = Cart::where('id',$id)->first();
        $cart->color = $request->color;
        $cart->size = $request->size;
        $cart->qty = $request->qty;
        $cart->price = $price;
        $cart->save();
        
        return response()->json([
            'message'   =>  'success',
        ], 201);

    }

    //delete cart ..............
    public function deleteCart($id){
        $cart = Cart::find($id);

        if($cart){
            if($cart->delete()){
                return response()->json([
                    'message'   =>  'success',
                ], 201);
    
            }else{
                return response()->json([
                    'message'   =>  'Something wrong.'
                ], 500);
            }
        }else{
            return response()->json([
                'message'   =>  'Cart Not Found.'
            ], 500);
        }

        
    }

}
