<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Auth;

class CountryController extends Controller
{
    
    public function index()
    {    
        $countries = Country::orderBy('id', 'desc')->get();
        return view('backend.country.index',compact('countries'));
    }


    public function create()
    {   
        return view('backend.country.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'country_name'=> 'required',
        ]);

        $data = $request->all();

        if(Country::create($data)){
           return redirect(route('country.index'))->with('message','Successfully Country Added');
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
        $country = Country::find($id);
        return view('backend.country.edit' , compact('country'));
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
            'country_name'=> 'required',
        ]);

        $data = $request->all();

        $country = Country::find($id);

        if($country->update($data)){
            return redirect(route('country.index'))->with('message','Successfully Country Updated');
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
        $country = Country::find($id);

        if($country->delete()){
            return redirect(route('country.index'))->with('message','Successfully Country Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }

}
