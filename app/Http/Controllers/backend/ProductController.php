<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Size;
use App\Models\Product;
use App\Models\BannerCategory;
use App\Models\ProductColorManage;
use App\Models\ProductTile;
use Auth;
use App\Models\ProductKeyword;
use App\Models\MiddleCategory;
use App\Models\ProductQuantity;

class ProductController extends Controller
{
    
    public function index()
    {    
        $products = Product::orderBy('id', 'desc')->get();
        $subCategories = SubCategory::orderBy('id', 'desc')->get();
        return view('backend.product.index',compact('products','subCategories'));
    }


    public function create()
    {   
        $categories = Category::orderBy('id', 'desc')->get();
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        $productKeywords = ProductKeyword::orderBy('id', 'desc')->get();
        return view('backend.product.create',compact('categories','bannerCategories','productKeywords'));
    }


    public function getMiddleCategoryCategoryWise(Request $request){

        $middleCategoryData = MiddleCategory::where('category_id', $request->categoryId)->get();
        return response()->json($middleCategoryData);

    }

    public function getSubCategoryMiddleCategoryWise(Request $request){

        $subCategoryData = SubCategory::where('middle_category_id', $request->middleCategoryId)->get();
        return response()->json($subCategoryData);
    }


    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id'=> 'required',
            'product_name'=> 'required|unique:products,product_name',
            'keyword'=> 'required',
        ]);

        $data = $request->all();
        
        $data['sub_category_id'] = json_encode($request->sub_category_id);
        $data['banner_category_id'] = json_encode($request->banner_category_id);
        $data['product_keyword'] = json_encode($request->keyword);

        $data['status'] = 0;

        if($request->product_video){
            $file = $request->file('product_video');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/product_video/');
            $file->move($destinationPath,$fileName);
            $data['product_video'] = $fileName;
        }

        if(Product::create($data)){
           return redirect(route('product.index'))->with('message','Successfully Product Added');
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $product = Product::find($id);
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        $subCategories = SubCategory::orderBy('id', 'desc')->get();
        $productColors = ProductColorManage::where('product_id',$product->id)->get();
        $productTiles = ProductTile::where('product_id',$product->id)->get();
        $productQuantitys = ProductQuantity::where('product_id',$product->id)->get();
        $sizes = Size::get();
        $productKeywords = ProductKeyword::get();
        return view('backend.product.edit' , compact('product','bannerCategories','subCategories','productColors','productTiles','sizes','productKeywords','productQuantitys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_category_id'=> 'required',
            'product_name'=> 'required',
        ]);

        $data = $request->all();
        $product = Product::find($id);

        $data['sub_category_id'] = json_encode($request->sub_category_id);
        $data['banner_category_id'] = json_encode($request->banner_category_id);
        $data['product_keyword'] = json_encode($request->keyword);
        
        
        if($request->product_video){
            //To remove previous file...
            $destinationPath = public_path('uploads/product_video/');
            if(file_exists($destinationPath.$product->product_video)){
                if($product->product_video != ''){
                    unlink($destinationPath.$product->product_video);
                }
            }

            $file = $request->file('product_video');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['product_video'] = $fileName;
        }

        if($product->update($data)){
            return redirect()->back()->with('message','Successfully Product Updated');
        }else{
            return redirect()->back()->with('error','Error !! Update Failed');;
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if($product->product_video){
            if (file_exists(public_path('uploads/product_video/'.$product->product_video))) {
                unlink(public_path('uploads/product_video/'.$product->product_video));
            }
        }

        if($product->delete()){
            return redirect(route('product.index'))->with('message','Successfully Product Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }


    public function details($id){

        $product = Product::where('id',$id)->first();
        $productColors = ProductColorManage::where('product_id',$product->id)->get();
        return view('backend.product.datails',compact('product','productColors'));
    }


    // product color management system .....................

    public function colorManagementSubmit(Request $request){

        $request->validate([
            'color_name'=> 'required',
            'product_id'=> 'required',
            'color_code'=> 'required',
            'product_images'=> 'required',
            'product_price'=> 'required',
        ]);

        $data = $request->all();

        $productId = $request->product_id;
        $colorName = $request->color_name;
        $colorcode = $request->color_code;
        $sizeId = json_encode($request->size_id);
        $productPrice = $request->product_price;

        $product_images = array();

        if($request->hasfile('product_images')){
            foreach($request->file('product_images') as $file)
            {   
                $random = random_int(1000000000, 9999999999);
                $fileName= $random.'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images/');
                $file->move($destinationPath,$fileName);
                $product_images[] = $fileName;
          }
        }

        ProductColorManage::insert([
            'product_id' => $productId,
            'color_name' => $colorName,
            'color_code' => $colorcode,
            'product_size' => $sizeId,
            'product_price' => $productPrice,
            'product_images' => json_encode($product_images),
        ]);

        return redirect()->back()->with('message','Successfully Product Color Added');
        
    }


    
    public function colorManagementUpdate(Request $request ,$id){

        /* $request->validate([
            'color_name'=> 'required',
            'color_code'=> 'required',
            'product_price'=> 'required',
        ]); */

        $data = $request->all();

        $productId = $request->product_id;
        $colorName = $request->color_name;
        $colorcode = $request->color_code;
        $sizeId = json_encode($request->size_id);
        $productPrice = $request->product_price;

        if($request->product_images){
            
            $product_images = array();

            if($request->hasfile('product_images')){
                foreach($request->file('product_images') as $file)
                {   
                    $random = random_int(1000000000, 9999999999);
                    $fileName= $random.'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/product_images/');
                    $file->move($destinationPath,$fileName);
                    $product_images[] = $fileName;
              }
            }

        }

        $color = ProductColorManage::where('id',$id)->first();
        $color->color_name = $colorName;
        $color->color_code = $colorcode;
        $color->product_size = $sizeId;
        $color->product_price = $productPrice;

        if($request->product_images){
        $color->product_images = json_encode($product_images);
        }
        
        $color->save();

        return redirect()->back()->with('message','Successfully Product Color Updated');
        
    }


    public function productColorDelete($id){

        $data = ProductColorManage::where('id', $id)->first();
        $images = json_decode($data->product_images);

        foreach($images as $key => $item){
            if (file_exists(public_path('uploads/product_images/'.$item))) {
                unlink(public_path('uploads/product_images/'.$item));
             }
        }
        
        if($data->delete()){
            return redirect()->back()->with('message','Successfully Product Color Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }
        
    }


    public function productTileAdd(Request $request){
        $request->validate([
            'title'=> 'required',
            'description'=> 'required',
        ]);

        ProductTile::insert([
            'product_id' => $request->product_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('message','Successfully Product Tile Added');
    }


    public function productTileUpdate(Request $request , $id){
        $request->validate([
            'title'=> 'required',
            'description'=> 'required',
        ]);

        $productTile = ProductTile::where('id',$id)->first();
        $productTile->title = $request->title;
        $productTile->description = $request->description;
        $productTile->save();

        return redirect()->back()->with('message','Successfully Product Tile Update');
    }


    //product active........
    public function active($id){

        $checkColor = ProductColorManage::where('product_id',$id)->first();
        $checkTile = ProductTile::where('product_id',$id)->first();

        if($checkColor){
            if($checkTile){
                $product = Product::where('id',$id)->first();
                $product->status = true;
                $product->save();
                return redirect()->back()->with('message','Successfully Product Active');
            }else{
                return redirect()->back()->with('error','At List Added 1 Product Tile !!');
            }
        }else{
            return redirect()->back()->with('error','At List Added 1 Product Color !!');
        }
        
    }


    //product inactive........
    public function inactive($id){

        $product = Product::where('id',$id)->first();
        $product->status = false;
        $product->save();

        return redirect()->back()->with('message','Successfully Product Inactive');
    }


    //multiple product delete....
    public function multipleDelete(Request $request){

        if($request->productIds != ''){
            $product = Product::whereIn('id',$request->productIds)->delete();
            return redirect()->route('product.index')->with('message','Successfully Products Deleted');
        }else{
            return redirect()->back();
        }

        
    }

    //product search....
    public function productSearch(Request $request){

        $products = Product::whereJsonContains('sub_category_id',$request->sub_category_id)->get();
        $subCategories = SubCategory::orderBy('id', 'desc')->get();
        return view('backend.product.index',compact('products','subCategories'));
    }


    public function getSizeColorWise(Request $request){

        $data = ProductColorManage::where('product_id', $request->productId)->where('color_name',$request->colorName)->first();
        $sizes = json_decode($data->product_size);
        return view('backend.product.colorWiseSize',compact('sizes'));
    }


    public function addProductQuantity(Request $request){

        $data = $request->all();

        if(ProductQuantity::create($data)){
           return redirect()->back()->with('message','Successfully Product Quantity Add');
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
        }
    }


    public function updateProductQuantity(Request $request,$id){

        $data = $request->all();

        $productQuantity = ProductQuantity::where('id',$id)->first();

         if($productQuantity->update($data)){
           return redirect()->back()->with('message','Successfully Product Quantity Update');
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
        }
    }

    
    

}
