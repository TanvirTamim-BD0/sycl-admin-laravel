<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerCategory;
use App\Models\TopBanner;
use Auth;

class TopBannerController extends Controller
{
    public function index()
    {    
        $topBanners = TopBanner::orderBy('id', 'desc')->get();
        return view('backend.topBanner.index',compact('topBanners'));
    }


    public function create()
    {      
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        return view('backend.topBanner.create',compact('bannerCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'banner_category_id'=> 'required',
            'top_banner_image'=> 'required',
        ]);

        $data = $request->all();
 
        if($request->top_banner_image){
            $file = $request->file('top_banner_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/top_banner_image/');
            $file->move($destinationPath,$fileName);
            $data['top_banner_image'] = $fileName;
        }

        if(TopBanner::create($data)){
           return redirect(route('top-banner.index'))->with('message','Successfully Top Banner Added');
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
        $topBanner = TopBanner::find($id);
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        return view('backend.topBanner.edit' , compact('topBanner','bannerCategories'));
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
            'banner_category_id'=> 'required',
        ]);

        $data = $request->all();

        $topBanner = TopBanner::find($id);
        if($request->top_banner_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/top_banner_image/');
            if(file_exists($destinationPath.$topBanner->top_banner_image)){
                if($topBanner->top_banner_image != ''){
                    unlink($destinationPath.$topBanner->top_banner_image);
                }
            }

            $file = $request->file('top_banner_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['top_banner_image'] = $fileName;
        }

        if($topBanner->update($data)){
            return redirect(route('top-banner.index'))->with('message','Successfully Top Banner Updated');
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
        $topBanner = TopBanner::find($id);

        if (file_exists(public_path('uploads/top_banner_image/'.$topBanner->top_banner_image))) {
            unlink(public_path('uploads/top_banner_image/'.$topBanner->top_banner_image));
         }

        if($topBanner->delete()){
            return redirect(route('top-banner.index'))->with('message','Successfully Top Banner Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }

}
