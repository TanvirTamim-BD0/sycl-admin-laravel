<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Country;
use App\Models\City;
use App\Models\University;
use Auth;

class AddressController extends Controller
{
    
    //get address customer id wise..........
    public function getAllAddressCustomerWise(){

        $customer_id = Auth::user()->id;
        $addressData = Address::where('customer_id',$customer_id)->with('countryData')->with('cityData')->with('universityData')->get();

        if(!empty($addressData)){
            return response()->json([
                'message'   =>  'success',
                'addressData'   =>  $addressData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }


    // add new address .............
    public function addNewAddress(Request $request){

        $request->validate([
            'first_name'=> 'required',
            'last_name'=> 'required',
            'mobile_number'=> 'required',
        ]);

        $data = $request->all();
        $data['customer_id'] = Auth::user()->id;

        if(Address::create($data)){
            return response()->json([
                'message'   =>  'success',
            ], 201);

        }else{
             return response()->json([
				'message'   =>  'Something wrong.'
			], 500);
        }

    }


    //address stutus active .......
    public function activeAddress($id){

        $customer_id = Auth::user()->id;

        //To get all the brand ids...
        $getAddressIds = Address::where('customer_id',$customer_id)->pluck('id');

        Address::whereIn('id', $getAddressIds)->update(['active_status' => false]);
        Address::where('id', $id)->update(['active_status' => true]);

        return response()->json([
            'message'   =>  'success',
        ], 201);

    }


    //delete address .......
    public function deleteAddress($id){
        $address = Address::find($id);
        if($address->delete()){
            return response()->json([
                'message'   =>  'success',
            ], 201);

        }else{
            return response()->json([
				'message'   =>  'Something wrong.'
			], 500);
        }
    }


    
    //get all country ..........
    public function getAllCountry(){

        $countryData = Country::orderBy('id','desc')->get();

        if(!empty($countryData)){
            return response()->json([
                'message'   =>  'success',
                'countryData'   =>  $countryData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }

     //get city country wise..........
     public function getCityCountryWise($id){

        $cityData = City::where('country_id',$id)->get();

        if(!empty($cityData)){
            return response()->json([
                'message'   =>  'success',
                'cityData'   =>  $cityData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }


     //get all institution ..........
     public function getAllInstitution(){

        $institutionData = University::orderBy('id','desc')->get();

        if(!empty($institutionData)){
            return response()->json([
                'message'   =>  'success',
                'institutionData'   =>  $institutionData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }
}
