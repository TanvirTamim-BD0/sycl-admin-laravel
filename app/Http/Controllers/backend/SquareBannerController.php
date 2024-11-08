<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SquareBanner;
use Auth;
use App\Models\BannerCategory;

class SquareBannerController extends Controller
{
    public function index()
    {    
        $squareBanners = SquareBanner::orderBy('id', 'desc')->get();
        return view('backend.squareBanner.index',compact('squareBanners'));
    }


    public function create()
    {      
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        return view('backend.squareBanner.create',compact('bannerCategories'));
    }


    public function store(Request $request)
    {   
        $request->validate([
            'banner_category_id'=> 'required',
            'square_banner_title'=> 'required',
            'square_banner_description'=> 'required',
            'square_banner_image'=> 'required',
        ]);

        $data = $request->all();
 
        if($request->square_banner_image){
            $file = $request->file('square_banner_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/square_banner_image/');
            $file->move($destinationPath,$fileName);
            $data['square_banner_image'] = $fileName;
        }

        if(SquareBanner::create($data)){
           return redirect(route('square-banner.index'))->with('message','Successfully Square Banner Added');
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
        $squareBanner = SquareBanner::find($id);
        $bannerCategories = BannerCategory::orderBy('id', 'desc')->get();
        return view('backend.squareBanner.edit' , compact('squareBanner','bannerCategories'));
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
            'square_banner_title'=> 'required',
            'square_banner_description'=> 'required',
        ]);

        $data = $request->all();

        $squareBanner = SquareBanner::find($id);
        if($request->square_banner_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/square_banner_image/');
            if(file_exists($destinationPath.$squareBanner->square_banner_image)){
                if($squareBanner->square_banner_image != ''){
                    unlink($destinationPath.$squareBanner->square_banner_image);
                }
            }

            $file = $request->file('square_banner_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['square_banner_image'] = $fileName;
        }

        if($squareBanner->update($data)){
            return redirect(route('square-banner.index'))->with('message','Successfully Square Banner Updated');
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
        $squareBanner = SquareBanner::find($id);

        if (file_exists(public_path('uploads/square_banner_image/'.$squareBanner->square_banner_image))) {
            unlink(public_path('uploads/square_banner_image/'.$squareBanner->square_banner_image));
         }

        if($squareBanner->delete()){
            return redirect(route('square-banner.index'))->with('message','Successfully Square Banner Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }
}
