<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerCategory;
use Auth;

class BannerCategoryController extends Controller
{
    public function index()
    {    
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        return view('backend.bannerCategory.index',compact('bannerCategories'));
    }


    public function create()
    {   
        return view('backend.bannerCategory.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'banner_category_name'=> 'required',
        ]);

        $data = $request->all();

        if(BannerCategory::create($data)){
           return redirect(route('banner-category.index'))->with('message','Successfully Banner Category Added');
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
        $bannerCategory = BannerCategory::find($id);
        return view('backend.bannerCategory.edit' , compact('bannerCategory'));
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
            'banner_category_name'=> 'required',
        ]);

        $data = $request->all();

        $bannerCategory = BannerCategory::find($id);

        if($bannerCategory->update($data)){
            return redirect(route('banner-category.index'))->with('message','Successfully Banner Category Updated');
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
        $bannerCategory = BannerCategory::find($id);

        if($bannerCategory->delete()){
            return redirect(route('banner-category.index'))->with('message','Successfully Banner Category Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }
}
