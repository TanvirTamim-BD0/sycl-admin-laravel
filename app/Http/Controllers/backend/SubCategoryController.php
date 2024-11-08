<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MiddleCategory;
use App\Models\SubCategory;
use Auth;
use App\Models\Product;

class SubCategoryController extends Controller
{
    
    public function index()
    {    
        $subCategories = SubCategory::orderBy('id', 'desc')->get();
        return view('backend.subCategory.index',compact('subCategories'));
    }


    public function create()
    {      
        $middleCategories = MiddleCategory::orderBy('id', 'desc')->get();
        return view('backend.subCategory.create',compact('middleCategories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'middle_category_id'=> 'required',
            'sub_category_name'=> 'required',
            'sub_category_image'=> 'required',
        ]);

        $data = $request->all();
 
        if($request->sub_category_image){
            $file = $request->file('sub_category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/sub_category_image/');
            $file->move($destinationPath,$fileName);
            $data['sub_category_image'] = $fileName;
        }

        if(SubCategory::create($data)){
           return redirect(route('sub-category.index'))->with('message','Successfully Sub Category Added');
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
        $subCategory = SubCategory::find($id);
        $middleCategories = MiddleCategory::orderBy('id', 'desc')->get();
        return view('backend.subCategory.edit' , compact('subCategory','middleCategories'));
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
            'middle_category_id'=> 'required',
            'sub_category_name'=> 'required',
        ]);

        $data = $request->all();

        $subCategory = SubCategory::find($id);
        
        if($request->sub_category_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/sub_category_image/');
            if(file_exists($destinationPath.$subCategory->sub_category_image)){
                if($subCategory->sub_category_image != ''){
                    unlink($destinationPath.$subCategory->sub_category_image);
                }
            }

            $file = $request->file('sub_category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['sub_category_image'] = $fileName;
        }

        if($subCategory->update($data)){
            return redirect(route('sub-category.index'))->with('message','Successfully Sub Category Updated');
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
        $subCategory = SubCategory::find($id);
        $product = Product::whereJsonContains('sub_category_id',$id)->first();

        if($product == null){

            if (file_exists(public_path('uploads/sub_category_image/'.$subCategory->sub_category_image))) {
                unlink(public_path('uploads/sub_category_image/'.$subCategory->sub_category_image));
            }

            if($subCategory->delete()){
                return redirect(route('sub-category.index'))->with('message','Successfully Sub Category Deleted');
            }else{
                return redirect()->back()->with('error','Error !! Delete Failed');
            }

        }else{
            return redirect()->back()->with('error','Error !! Product has been created with this sub category');
        }      
    }

}
