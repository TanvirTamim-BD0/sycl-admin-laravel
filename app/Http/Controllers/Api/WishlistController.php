<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Wishlist;
use App\Models\ProductColorManage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WishlistController extends Controller
{
    
    //get wishlist ..............
    public function getWishList(Request $request)
    {   
        $customer_id= Auth::user()->id;

        $data = Wishlist::where('customer_id',$customer_id)->pluck('product_id');
       

        if($request->sort != null){
            if($request->sort == 'newest'){
                $wishlistData = Wishlist::where('customer_id',$customer_id)->with('productData')->with('colorData')->orderBy('id','desc')->get();
            }

            if($request->sort == 'oldest'){
                $wishlistData = Wishlist::where('customer_id',$customer_id)->with('productData')->with('colorData')->orderBy('id','asc')->get();
            }

            if($request->sort == 'priceLowToHigh'){
                $productId = ProductColorManage::whereIn('product_id',$data)->orderBy('product_price','asc')->groupBy('product_id')->pluck('product_id');

                $wishlistData = array();
                    foreach($productId as $id){
                        $wishlistData[] = Wishlist::where('customer_id',$customer_id)->where('product_id',$id)->with('productData')->with('colorData')->first();
                    }

                $result = array_filter($wishlistData);
                $wishlistData = $this->pagination($result);
            }


            if($request->sort == 'priceHighToLow'){
                $productId = ProductColorManage::whereIn('product_id',$data)->orderBy('product_price','desc')->groupBy('product_id')->pluck('product_id');

                $wishlistData = array();
                    foreach($productId as $id){
                        $wishlistData[] = Wishlist::where('customer_id',$customer_id)->where('product_id',$id)->with('productData')->with('colorData')->first();
                    }

                $result = array_filter($wishlistData);
                $wishlistData = $this->pagination($result);
            }
            
    
        }else{
            $wishlistData = Wishlist::where('customer_id',$customer_id)->with('productData')->with('colorData')->get();
        }

        

        if(!empty($wishlistData)){
            return response()->json([
                'message'   =>  'success',
                'wishlistData'   =>  $wishlistData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }
    }


    //add wishlist ..............
    public function addWishList($id){

        $data['product_id'] = $id;
        $data['customer_id'] = Auth::user()->id;
        $customerId = Auth::user()->id;

        $check = Wishlist::where('customer_id',$customerId)->where('product_id',$id)->first();
        
        if($check == null){
            
            if(Wishlist::create($data)){
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
                'message'   =>  'Product AllReady Added Wishlist !!.'
            ], 500);
        }
        
    }

    //delete wishlist ..............
    public function deleteWishlist($id){

        $customerId = Auth::user()->id;

        $wishlist = Wishlist::where('customer_id',$customerId)->where('product_id',$id)->first();

        if($wishlist){
            if($wishlist->delete()){
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
                'message'   =>  'Wishlist Not Found.'
            ], 500);
        }
        
    }


    //delete wishlist ..............
    public function deleteWishlistProductList($id){
        $wishlist = Wishlist::find($id);

        if($wishlist){
            if($wishlist->delete()){
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
                'message'   =>  'Wishlist Not Found.'
            ], 500);
        }
        
    }
    
    //clear wishlist..........
    public function clearWishlist(){

        $customerId = Auth::user()->id;
        $delete = Wishlist::where('customer_id',$customerId)->delete();
        return response()->json([
            'message'   =>  'success',
        ], 201);

    }


    //count wishlist product........
    public function getProductTotalWishlistCount($id){

        $data = Wishlist::where('product_id',$id)->count();

        if(!empty($data)){
            return response()->json([
                'message'   =>  'success',
                'data'   =>  $data,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'success',
                'data'   =>  0,
			], 500);
        }

    }


    public function pagination($items, $perPage = 8, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 8);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
