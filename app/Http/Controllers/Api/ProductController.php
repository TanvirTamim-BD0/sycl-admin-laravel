<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductKeyword;
use Auth;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\ProductColorManage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\ProductQuantity;

class ProductController extends Controller
{   

    //get single product ....................
    public function getSingleProduct($id){
        
        $productData = Product::where('id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

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

    //get single product after authentication ....................
    public function getSingleProductAuth($id){
        
        $customer_id= Auth::user()->id;
        $wishlistData = Wishlist::where('customer_id',$customer_id)->where('product_id',$id)->first();
        $cartData = Cart::where('customer_id',$customer_id)->where('product_id',$id)->first();

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

        $productData = Product::where('id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

        if(!empty($productData)){
            return response()->json([
                'message'   =>  'success',
                'productData'   =>  $productData,
                'wishlist'   =>  $wishlist,
                'cart'   =>  $cart,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }


    //get product sub category wise ...........
    public function getProductSubCategoryWise(Request $request ,$id){
        
        $subCategoryId = $id;

        //color detail get ..........
        if($request->color != null){
            $color = explode(',', $request->color);
            $colorData = ProductColorManage::whereIn('color_name',$color)->get();

            $colorProductId = array();
            foreach($colorData as $color){
                $colorProductId[] = $color->product_id;
            }
        }else{
            $colorProductId[] = null;
        }
        
        
         //size detail get ..........
        if($request->size != null){
            $size = explode(',', $request->size);
            $sizeData = ProductColorManage::whereJsonContains('product_size',$size)->get();
            $sizeProductId = array();
            foreach($sizeData as $size){
                $sizeProductId[] = $size->product_id;
            }
        }else{
            $sizeProductId[] = null;
        }

        
        if($request->sort != null){
            
          if($request->sort == 'newest'){
            
            if($request->color != null){
                if($request->size != null){
                    $productData = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();
                    
                    $products = $this->pagination($productData);

                }else{
                    $productData = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
                }
            }else{
            
                if($request->size != null){
                    $productData = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
                }else{
                    $productData = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
                }
            }

          }

          if($request->sort == 'oldest'){
            if($request->color != null){

                if($request->size != null){
                    $productData = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
            
                }else{
                    $productData = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
                }
               
            }else{
            
                if($request->size != null){
                    $productData = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
            
                }else{
                    $productData = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
                }

            }
          }
          

            if($request->sort == 'priceLowToHigh'){

                $productId = ProductColorManage::orderBy('product_price','asc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }


            if($request->sort == 'priceHighToLow'){

                $productId = ProductColorManage::orderBy('product_price','desc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }

              

        }else{

            if($request->color != null){
                if($request->size != null){
                    $productData = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
            
                }else{
                    $productData = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
                }
            }else{
            
                if($request->size != null){
                    $productData = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();
                    $products = $this->pagination($productData);
                }else{
                    $productData = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                    $products = $this->pagination($productData);
                }
            }

        }


        $productData = [];
        foreach($products as $item){
            if($item != null){
                $productData[] = array(
                    'productData' => $item,
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


    //get product sub category wise after authentication...........
    public function getProductSubCategoryWiseAuth(Request $request ,$id){
        
        $subCategoryId = $id;
        
       //color detail get ..........
        if($request->color != null){
            $color = explode(',', $request->color);
            $colorData = ProductColorManage::whereIn('color_name',$color)->get();

            $colorProductId = array();
            foreach($colorData as $color){
                $colorProductId[] = $color->product_id;
            }
        }else{
            $colorProductId[] = null;
        }
        
        
         //size detail get ..........
        if($request->size != null){
            $size = explode(',', $request->size);
            $sizeData = ProductColorManage::whereJsonContains('product_size',$size)->get();

            $sizeProductId = array();
            foreach($sizeData as $size){
                $sizeProductId[] = $size->product_id;
            }
        }else{
            $sizeProductId[] = null;
        }

        if($request->sort != null){
            
            if($request->sort == 'newest'){
              
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('sub_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
  
            }
  
            if($request->sort == 'oldest'){
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();
                      $products = $this->pagination($products);
                  }else{
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('sub_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
            }  

            if($request->sort == 'priceLowToHigh'){

                $productId = ProductColorManage::orderBy('product_price','asc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }


            if($request->sort == 'priceHighToLow'){

                $productId = ProductColorManage::orderBy('product_price','desc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('sub_category_id',$subCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }

              
          }else{
  
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::whereJsonContains('sub_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
  
          }


        $productData = [];
        foreach($products as $item){
            if($item != null){
                $customer_id= Auth::user()->id;
                $wishlistData = Wishlist::where('customer_id',$customer_id)->where('product_id',$item->id)->first();
                $cartData = Cart::where('customer_id',$customer_id)->where('product_id',$item->id)->first();

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


    //get product banner category wise ...........
    public function getProductBannerCategoryWise(Request $request ,$id){

        $bannerCategoryId = $id;

         //color detail get ..........
         if($request->color != null){
            $color = explode(',', $request->color);
            $colorData = ProductColorManage::whereIn('color_name',$color)->get();

            $colorProductId = array();
            foreach($colorData as $color){
                $colorProductId[] = $color->product_id;
            }
        }else{
            $colorProductId[] = null;
        }
        
        
         //size detail get ..........
        if($request->size != null){
            $size = explode(',', $request->size);
            $sizeData = ProductColorManage::whereJsonContains('product_size',$size)->get();

            $sizeProductId = array();
            foreach($sizeData as $size){
                $sizeProductId[] = $size->product_id;
            }
        }else{
            $sizeProductId[] = null;
        }


        if($request->sort != null){
            
            if($request->sort == 'newest'){
              
              if($request->color != null){
  
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
  
              }
  
            }
  
            if($request->sort == 'oldest'){
              if($request->color != null){
  
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
  
              }
            } 
            
            if($request->sort == 'priceLowToHigh'){

                $productId = ProductColorManage::orderBy('product_price','asc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }

            if($request->sort == 'priceHighToLow'){

                $productId = ProductColorManage::orderBy('product_price','desc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }
              
          }else{
  
              if($request->color != null){
  
                  if($request->size != null){
                      $productData = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();
                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $productData = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
  
              }
  
          }

        $productData = [];
        foreach($products as $item){
            if($item != null){
                $productData[] = array(
                    'productData' => $item,
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


    //get product banner category wise after authentication...........
    public function getProductBannerCategoryWiseAuth(Request $request ,$id){

        $bannerCategoryId = $id;

        //color detail get ..........
        if($request->color != null){
            $color = explode(',', $request->color);
            $colorData = ProductColorManage::whereIn('color_name',$color)->get();

            $colorProductId = array();
            foreach($colorData as $color){
                $colorProductId[] = $color->product_id;
            }
        }else{
            $colorProductId[] = null;
        }
        
        
         //size detail get ..........
        if($request->size != null){
            $size = explode(',', $request->size);
            $sizeData = ProductColorManage::whereJsonContains('product_size',$size)->get();

            $sizeProductId = array();
            foreach($sizeData as $size){
                $sizeProductId[] = $size->product_id;
            }
        }else{
            $sizeProductId[] = null;
        }


        if($request->sort != null){
            
            if($request->sort == 'newest'){
              
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();
                      
                      $products = $this->pagination($products);
                  }else{
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();
                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('banner_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
  
            }
  
            if($request->sort == 'oldest'){
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('banner_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
            }
            
            if($request->sort == 'priceLowToHigh'){

                $productId = ProductColorManage::orderBy('product_price','asc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }


            if($request->sort == 'priceHighToLow'){

                $productId = ProductColorManage::orderBy('product_price','desc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('banner_category_id',$bannerCategoryId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }

              
          }else{
  
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::whereJsonContains('banner_category_id',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
  
          }


        $productData = [];
        foreach($products as $item){
            if($item != null){
                $customer_id= Auth::user()->id;
                $wishlistData = Wishlist::where('customer_id',$customer_id)->where('product_id',$item->id)->first();
                $cartData = Cart::where('customer_id',$customer_id)->where('product_id',$item->id)->first();

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


     //get all keyword data...........
     public function getKeyword($data)
     {
         $keywordData = ProductKeyword::where('keyword_name' , 'like' ,'%'.$data.'%')->get();
 
         if(!empty($keywordData)){
             return response()->json([
                 'message'   =>  'success',
                 'keywordData'   =>  $keywordData,
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Sorry you have no data.'
             ], 500);
         }
     }
     

    //get product keyword wise ...........
    public function getProductKeywordWise(Request $request ,$id){
        
        $productKeyword = $id;

         //color detail get ..........
         if($request->color != null){
            $color = explode(',', $request->color);
            $colorData = ProductColorManage::whereIn('color_name',$color)->get();

            $colorProductId = array();
            foreach($colorData as $color){
                $colorProductId[] = $color->product_id;
            }
        }else{
            $colorProductId[] = null;
        }
        
        
         //size detail get ..........
        if($request->size != null){
            $size = explode(',', $request->size);
            $sizeData = ProductColorManage::whereJsonContains('product_size',$size)->get();

            $sizeProductId = array();
            foreach($sizeData as $size){
                $sizeProductId[] = $size->product_id;
            }
        }else{
            $sizeProductId[] = null;
        }


        if($request->sort != null){
            
            if($request->sort == 'newest'){
              
              if($request->color != null){
  
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
  
              }
  
            }
  
            if($request->sort == 'oldest'){
              if($request->color != null){
  
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();
                      $products = $this->pagination($productData);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
  
              }
            } 

            if($request->sort == 'priceLowToHigh'){

                $productId = ProductColorManage::orderBy('product_price','asc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }


            if($request->sort == 'priceHighToLow'){

                $productId = ProductColorManage::orderBy('product_price','desc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }

              
          }else{
  
              if($request->color != null){
  
                  if($request->size != null){
                      $productData = Product::whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();
                      $products = $this->pagination($productData);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $productData = Product::whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();
                      
                      $products = $this->pagination($productData);
              
                  }else{
                      $productData = Product::whereJsonContains('product_keyword',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($productData);
                  }
  
              }
  
          }


          $productData = [];
          foreach($products as $item){
              if($item != null){
                  $productData[] = array(
                      'productData' => $item,
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


    //get product keyword wise Auth...........
    public function getProductKeywordWiseAuth(Request $request ,$id){
        
        $productKeyword = $id;

         //color detail get ..........
         if($request->color != null){
            $color = explode(',', $request->color);
            $colorData = ProductColorManage::whereIn('color_name',$color)->get();

            $colorProductId = array();
            foreach($colorData as $color){
                $colorProductId[] = $color->product_id;
            }
        }else{
            $colorProductId[] = null;
        }
        
        
         //size detail get ..........
        if($request->size != null){
            $size = explode(',', $request->size);
            $sizeData = ProductColorManage::whereJsonContains('product_size',$size)->get();

            $sizeProductId = array();
            foreach($sizeData as $size){
                $sizeProductId[] = $size->product_id;
            }
        }else{
            $sizeProductId[] = null;
        }


        if($request->sort != null){
            
            if($request->sort == 'newest'){
              
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'desc')->whereJsonContains('product_keyword',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
  
            }
  
            if($request->sort == 'oldest'){
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::orderBy('id', 'asc')->whereJsonContains('product_keyword',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
            }  

            if($request->sort == 'priceLowToHigh'){

                $productId = ProductColorManage::orderBy('product_price','asc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }


            if($request->sort == 'priceHighToLow'){

                $productId = ProductColorManage::orderBy('product_price','desc')->groupBy('product_id')->pluck('product_id');
                
                if($request->color != null){

                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$colorProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
                   
                }else{
                
                    if($request->size != null){

                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->whereIn('id',$sizeProductId)->with('productTile')->with('colorData')->where('status',true)->first();
                        }
    
                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                
                    }else{
                        $productData = array();
                        foreach($productId as $id){
                            $productData[] = Product::where('id',$id)->whereJsonContains('product_keyword',$productKeyword)->with('productTile')->with('colorData')->where('status',true)->first();
                        }

                        $result = array_filter($productData);
                        $products = $this->pagination($result);
                    }
    
                }
                
            }

              
          }else{
  
              if($request->color != null){
  
                  if($request->size != null){
                      $products = Product::whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$colorProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
                 
              }else{
              
                  if($request->size != null){
                      $products = Product::whereJsonContains('product_keyword',$id)->with('productTile')->whereIn('id',$sizeProductId)->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
              
                  }else{
                      $products = Product::whereJsonContains('product_keyword',$id)->with('productTile')->with('colorData')->where('status',true)->get();

                      $products = $this->pagination($products);
                  }
  
              }
  
          }


        $productData = [];
        foreach($products as $item){
            if($item != null){
                $customer_id= Auth::user()->id;
                $wishlistData = Wishlist::where('customer_id',$customer_id)->where('product_id',$item->id)->first();
                $cartData = Cart::where('customer_id',$customer_id)->where('product_id',$item->id)->first();

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


    //get all size .........
    public function GetAllSize(){

        $sizeData = Size::pluck('size_name');
 
        if(!empty($sizeData)){
            return response()->json([
                'message'   =>  'success',
                'sizeData'   =>  $sizeData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }

    }


    //get all color .......
    public function GetAllColor(){

        $colorData = ProductColorManage::select(['color_name','color_code'])->groupBy(['color_name','color_code'])->get();
        
        if(!empty($colorData)){
            return response()->json([
                'message'   =>  'success',
                'colorData'   =>  $colorData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }

    }


    public function getYouMayLikeProduct($id){ 

        $data = Product::where('id',$id)->first();
        $subCate = $data->sub_category_id;
        $subCateDecode =json_decode($subCate);
        $subCategory = $subCateDecode[0];

        $products = Product::whereJsonContains('sub_category_id',$subCategory)->with('colorData')->with('productTile')->where('id', '!=', $id)->limit(10)->get();

        $productData = [];
        foreach($products as $item){
            if($item != null){
                $productData[] = array(
                    'productData' => $item,
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

    public function getYouMayLikeProductAuth($id){ 
        
        $data = Product::where('id',$id)->first();
        $subCate = $data->sub_category_id;
        $subCateDecode =json_decode($subCate);
        $subCategory = $subCateDecode[0];

        $products = Product::whereJsonContains('sub_category_id',$subCategory)->with('colorData')->with('productTile')->where('id', '!=', $id)->limit(10)->get();

        $productData = [];
        foreach($products as $item){
            if($item != null){
                $customer_id= Auth::user()->id;
                $wishlistData = Wishlist::where('customer_id',$customer_id)->where('product_id',$item->id)->first();
                $cartData = Cart::where('customer_id',$customer_id)->where('product_id',$item->id)->first();

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


    public function pagination($items, $perPage = 8, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 8);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }



    public function getQuantityColorSizeWise(Request $request)
    {
        $data = ProductQuantity::where('product_id',$request->product_id)->where('color_name',$request->color)->where('size_name',$request->size)->first();

        if(!empty($data)){
            return response()->json([
                'message'   =>  'success',
                'data'   =>  $data,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
        
    }

}
