<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use App\Models\MiddleCategory;

class CategoryController extends Controller
{   

    public function index()
    {    
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.category.index',compact('categories'));
    }


    public function create()
    {   
        return view('backend.category.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_name'=> 'required',
            'category_image'=> 'required',
        ]);

        $data = $request->all();
 
        if($request->category_image){
            $file = $request->file('category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/category_image/');
            $file->move($destinationPath,$fileName);
            $data['category_image'] = $fileName;
        }

        if(Category::create($data)){
           return redirect(route('category.index'))->with('message','Successfully Category Added');
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
        $category = Category::find($id);
        return view('backend.category.edit' , compact('category'));
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
            'category_name'=> 'required',
        ]);

        $data = $request->all();

        $category = Category::find($id);
        if($request->category_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/category_image/');
            if(file_exists($destinationPath.$category->category_image)){
                if($category->category_image != ''){
                    unlink($destinationPath.$category->category_image);
                }
            }

            $file = $request->file('category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['category_image'] = $fileName;
        }

        if($category->update($data)){
            return redirect(route('category.index'))->with('message','Successfully Category Updated');
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
        $category = Category::find($id);

        $middleCatgeory = MiddleCategory::where('category_id',$category->id)->first();
       
        if($middleCatgeory == null){
            if (file_exists(public_path('uploads/category_image/'.$category->category_image))) {
                unlink(public_path('uploads/category_image/'.$category->category_image));
             }
    
            if($category->delete()){
                return redirect(route('category.index'))->with('message','Successfully Category Deleted');
            }else{
                return redirect()->back()->with('error','Error !! Delete Failed');
            }
        }else{
            return redirect()->back()->with('error','Error !! Middle category has been created with this category');
        }

    }

    
}
