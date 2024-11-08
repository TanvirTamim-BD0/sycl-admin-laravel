<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Auth;
use App\Models\ProductColorManage;

class SizeController extends Controller
{
    
    public function index()
    {    
        $sizes = Size::orderBy('id', 'desc')->get();
        return view('backend.size.index',compact('sizes'));
    }


    public function create()
    {   
        return view('backend.size.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'size_name'=> 'required|unique:sizes,size_name',
        ]);

        $data = $request->all();

        if(Size::create($data)){
            return redirect()->back()->with('message','Successfully Size Added');
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
        $size = Size::find($id);
        return view('backend.size.edit' , compact('size'));
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
            'size_name'=> 'required',
        ]);

        $data = $request->all();

        $size = Size::find($id);

        if($size->update($data)){
            return redirect(route('size.index'))->with('message','Successfully Size Updated');
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
        $size = Size::find($id);
        $sizeName = $size->size_name;

        $product = ProductColorManage::whereJsonContains('product_size',$sizeName)->first();

        if($product == null){
            if($size->delete()){
                return redirect(route('size.index'))->with('message','Successfully Size Deleted');
            }else{
                return redirect()->back()->with('error','Error !! Delete Failed');
            }

        }else{
            return redirect()->back()->with('error','Error !! Product has been created with this size');
        }

    }

}
