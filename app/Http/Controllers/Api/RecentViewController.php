<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecentViewProduct;
use Auth;
use App\Models\Wishlist;
use App\Models\Cart;

class RecentViewController extends Controller
{
    
     //get recent view product ..............
     public function getRecentViewProduct()
     {   
         $customer_id= Auth::user()->id;
 
         $products = RecentViewProduct::where('customer_id',$customer_id)->with('productData')->with('colorData')->orderBy('id','desc')->limit(15)->get();

         $productData = [];
         foreach($products as $item){
             if($item != null){
                 $customer_id= Auth::user()->id;
                 $wishlistData = Wishlist::where('customer_id',$customer_id)->where('product_id',$item->product_id)->first();
                 $cartData = Cart::where('customer_id',$customer_id)->where('product_id',$item->product_id)->first();
 
                 if($wishlistData){
                     $wishlist = true;
                 }else{
                     $wishlist = false;
                 }
 
                 if($cartData){
                     $cart = true;
                 }else{
                     $cart = false;
                 }
 
                 $productData[] = array(
                     'productData' => $item,
                     'wishlist' => $wishlist,
                     'cart' => $cart,
                 );
             }
         }

 
         if(!empty($productData)){
             return response()->json([
                 'message'   =>  'success',
                 'productData'   =>  $productData,
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Sorry you have no data.'
             ], 500);
         }
     }


      //add recent view product ..............
      public function addRecentViewProduct($id)
      {  
        $customer_id= Auth::user()->id;
        $check = RecentViewProduct::where('customer_id',$customer_id)->where('product_id',$id)->first();

        if($check){
            $delete = RecentViewProduct::where('customer_id',$customer_id)->where('product_id',$id)->delete();
            $data['customer_id'] = Auth::user()->id;
            $data['product_id'] = $id;

            if(RecentViewProduct::create($data)){
                return response()->json([
                    'message'   =>  'success',
                ], 201);

            }else{
                return response()->json([
                    'message'   =>  'Something wrong.'
                ], 500);
            }
        }else{
            $data['customer_id'] = Auth::user()->id;
            $data['product_id'] = $id;

            if(RecentViewProduct::create($data)){
                return response()->json([
                    'message'   =>  'success',
                ], 201);

            }else{
                return response()->json([
                    'message'   =>  'Something wrong.'
                ], 500);
            }
        }
        
      }

      //clear recent view product........
      public function clearRecentViewProduct(){

        $customerId = Auth::user()->id;
        $delete = RecentViewProduct::where('customer_id',$customerId)->delete();
        return response()->json([
            'message'   =>  'success',
        ], 201);

    }

}
