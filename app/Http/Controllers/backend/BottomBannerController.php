<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BottomBannner;
use Auth;
use App\Models\BannerCategory;

class BottomBannerController extends Controller
{
    public function index()
    {    
        $bottomBanners = BottomBannner::orderBy('id', 'desc')->get();
        return view('backend.bottomBanner.index',compact('bottomBanners'));
    }


    public function create()
    {   
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        return view('backend.bottomBanner.create',compact('bannerCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bottom_banner_image'=> 'required',
            'bottom_banner_text_1'=> 'required',
            'banner_category_id'=> 'required',
        ]);

        $data = $request->all();
 
        if($request->bottom_banner_image){
            $file = $request->file('bottom_banner_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/bottom_banner_image/');
            $file->move($destinationPath,$fileName);
            $data['bottom_banner_image'] = $fileName;
        }

        if(BottomBannner::create($data)){
           return redirect(route('bottom-banner.index'))->with('message','Successfully Bottom Bannner Added');
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
        $bottomBanner = BottomBannner::find($id);
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        return view('backend.bottomBanner.edit' , compact('bottomBanner','bannerCategories'));
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
            'bottom_banner_text_1'=> 'required',
            'banner_category_id'=> 'required',
        ]);

        $data = $request->all();

        $bottomBanner = BottomBannner::find($id);
        if($request->bottom_banner_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/bottom_banner_image/');
            if(file_exists($destinationPath.$bottomBanner->bottom_banner_image)){
                if($bottomBanner->bottom_banner_image != ''){
                    unlink($destinationPath.$bottomBanner->bottom_banner_image);
                }
            }

            $file = $request->file('bottom_banner_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['bottom_banner_image'] = $fileName;
        }

        if($bottomBanner->update($data)){
            return redirect(route('bottom-banner.index'))->with('message','Successfully Bottom Bannner Updated');
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
        $bottomBanner = BottomBannner::find($id);

        if (file_exists(public_path('uploads/bottom_banner_image/'.$bottomBanner->bottom_banner_image))) {
            unlink(public_path('uploads/bottom_banner_image/'.$bottomBanner->bottom_banner_image));
         }

        if($bottomBanner->delete()){
            return redirect(route('bottom-banner.index'))->with('message','Successfully Bottom Bannner Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }

}
