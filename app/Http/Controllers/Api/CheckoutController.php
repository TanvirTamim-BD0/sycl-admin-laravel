<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cart;
use App\Models\ProductColorManage;
use App\Models\Address;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkout(Request $request){
        
        $customer_id= Auth::user()->id;
        $cartData = Cart::where('customer_id',$customer_id)->with('productData')->with('colorData')->orderBy('id','desc')->get();
        
        $carts = [];
        foreach($cartData as $item){
            if($item != null){
                $productData = Product::where('id',$item->product_id)->first();
                $productColorData = ProductColorManage::where('product_id',$item->product_id)->where('color_name',$item->color)->whereJsonContains('product_size',$item->size)->first();

                $carts[] = array(
                    'product_name' => $productData->product_name,
                    'color' => $item->color,
                    'size' => $item->size,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'image' => $productColorData->product_images,
                );
            }
        }


        $avaragePrice = [];
        foreach($cartData as $data){
            $totalQtyPrice = $data->price * $data->qty;

            $avaragePrice[] = array(
                'price' => $totalQtyPrice,
            );

        }

        $subTotal = 0;
        foreach($avaragePrice as $price){
            $singlePrice = $price['price'];
            $subTotal += $singlePrice;
        }

        if($request->address_id){
            $addressData = Address::where('customer_id',$customer_id)->where('id',$request->address_id)->with('countryData')->with('cityData')->with('universityData')->first();
        }else{

            $checkActiveAddress = Address::where('customer_id',$customer_id)->where('active_status',true)->first();
            
            if($checkActiveAddress != null){
                $addressData = Address::where('customer_id',$customer_id)->where('active_status',true)->with('countryData')->with('cityData')->with('universityData')->first();
            }else{
                $addressData = Address::where('customer_id',$customer_id)->with('countryData')->with('cityData')->with('universityData')->first();
            }
        }

        $countCart = Cart::where('customer_id',$customer_id)->with('productData')->with('colorData')->orderBy('id','desc')->count();
        
        if($addressData != null){

            if($addressData->address_type == 'Institution Address'){
                $shippingFee = 0;
            }else{
                $defaultFee = 600;
                $totalItem = $countCart*200;
                $totalShippingFee = $defaultFee + $totalItem;
                
                if($totalShippingFee > 1800){
                    $shippingFee = 1800;
                }else{
                    $shippingFee = $totalShippingFee;
                }
            }
    
            $total = $subTotal + $shippingFee;
    
            if(!empty($cartData)){
                return response()->json([
                    'message'   =>  'success',
                    'productData'   =>  $carts,
                    'subTotal'   =>  $subTotal,
                    'shippingFee'   =>  $shippingFee,
                    'total'   =>  $total,
                    'addressData'   =>  $addressData,
                ], 201);
            }else{
                return response()->json([
                    'message'   =>  'Sorry you have no data.'
                ], 500);
            }

        }else{
            return response()->json([
                'message'   =>  'At first add your address.'
            ], 500);
        }

    }

    
    
}
