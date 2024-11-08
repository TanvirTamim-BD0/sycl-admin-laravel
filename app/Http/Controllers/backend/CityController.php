<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;

class CityController extends Controller
{
    
    public function index()
    {    
        $cities = City::orderBy('id', 'desc')->get();
        return view('backend.city.index',compact('cities'));
    }


    public function create()
    {      
        $countries = Country::orderBy('id', 'desc')->get();
        return view('backend.city.create',compact('countries'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'country_id'=> 'required',
            'city_name'=> 'required',
        ]);

        $data = $request->all();

        if(City::create($data)){
           return redirect(route('city.index'))->with('message','Successfully City Added');
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
        $city = City::find($id);
        $countries = Country::orderBy('id', 'desc')->get();
        return view('backend.city.edit' , compact('city','countries'));
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
            'country_id'=> 'required',
            'city_name'=> 'required',
        ]);

        $data = $request->all();

        $city = City::find($id);
        
        if($city->update($data)){
            return redirect(route('city.index'))->with('message','Successfully City Updated');
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
        $city = City::find($id);

        if($city->delete()){
            return redirect(route('city.index'))->with('message','Successfully City Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }

}
