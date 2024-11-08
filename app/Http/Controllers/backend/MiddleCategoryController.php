<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MiddleCategory;
use Auth;
use App\Models\SubCategory;

class MiddleCategoryController extends Controller
{
    
    public function index()
    {    
        $middleCategories = MiddleCategory::orderBy('id', 'desc')->get();
        return view('backend.middleCategory.index',compact('middleCategories'));
    }


    public function create()
    {      
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.middleCategory.create',compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id'=> 'required',
            'middle_category_name'=> 'required',
        ]);

        $data = $request->all();

        if(MiddleCategory::create($data)){
           return redirect(route('middle-category.index'))->with('message','Successfully Middle Added');
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
        $middleCategory = MiddleCategory::find($id);
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.middleCategory.edit' , compact('middleCategory','categories'));
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
            'category_id'=> 'required',
            'middle_category_name'=> 'required',
        ]);

        $data = $request->all();

        $middleCategory = MiddleCategory::find($id);
        
        if($middleCategory->update($data)){
            return redirect(route('middle-category.index'))->with('message','Successfully Middle Category Updated');
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
        $middleCategory = MiddleCategory::find($id);
        
        $subCatgeory = SubCategory::where('middle_category_id',$middleCategory->id)->first();

        if($subCatgeory == null){
            if($middleCategory->delete()){
                return redirect(route('middle-category.index'))->with('message','Successfully Middle Category Deleted');
            }else{
                return redirect()->back()->with('error','Error !! Delete Failed');
            }
        }else{
            return redirect()->back()->with('error','Error !! Sub category has been created with this middle category');
        }    
    }

}
