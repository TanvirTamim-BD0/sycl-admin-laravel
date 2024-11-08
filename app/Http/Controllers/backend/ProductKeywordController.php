<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductKeyword;
use Auth;
use App\Models\Product;

class ProductKeywordController extends Controller
{
    
    public function index()
    {    
        $productKeywords = ProductKeyword::orderBy('id', 'desc')->get();
        return view('backend.productKeyword.index',compact('productKeywords'));
    }


    public function create()
    {   
        return view('backend.productKeyword.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'keyword_name'=> 'required',
        ]);

        $data = $request->all();

        if(ProductKeyword::create($data)){
            return redirect()->back()->with('message','Successfully Keyword Added');
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
        $keyword = ProductKeyword::find($id);
        return view('backend.productKeyword.edit' , compact('keyword'));
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
            'keyword_name'=> 'required',
        ]);

        $data = $request->all();

        $keyword = ProductKeyword::find($id);

        if($keyword->update($data)){
            return redirect(route('keyword.index'))->with('message','Successfully Keyword Updated');
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
        $productKeyword = ProductKeyword::find($id);

        $product = Product::whereJsonContains('product_keyword',$id)->first();

        if($product == null){
            if($productKeyword->delete()){
                return redirect(route('keyword.index'))->with('message','Successfully Keyword Deleted');
            }else{
                return redirect()->back()->with('error','Error !! Delete Failed');
            }
        }else{
            return redirect()->back()->with('error','Error !! Product has been created with this keyword');
        } 

    }


}
