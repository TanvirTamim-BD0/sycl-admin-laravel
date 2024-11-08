<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{  

/* ---------------- Google Section --------------------- */

    /* -------google register --------- */
    public function socialRegisterGoogle(Request $request)
    {   
        $provider = "google";
        $token = $request->token;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $phone_number = $request->phone_number;
        $date_of_birth = $request->date_of_birth;

        $providerUser = Socialite::driver($provider)->userFromToken($token);
        
        if($providerUser->email === $email){

            $customer = Customer::where('provider_name', $provider)->where('provider_id', $providerUser->id)->first();
            if($customer == null){
                $data = customer::create([
                    'provider_name' => $provider,
                    'provider_id' => $providerUser->id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'date_of_birth' => $date_of_birth,
                ]);

                $customerData = Customer::where('id', $data->id)->first();
                $accessToken = $customerData->createToken('syclecommerce')->accessToken;

                $data = [
                    'message' => 'Successfully Register Account',
                    'access_token' => $accessToken,
                    'customerData' => $customerData,
                ]; 
                return response()->json($data);

            }else{
                return response()->json([
                    'message'   =>  'All Ready Exist Customer.!'
                ], 500);
            }

        }else{
            return response()->json([
                'message'   =>  'Email Not Match.!'
            ], 500);
        }
        

    }


    /* -------google login --------- */
     public function socialLoginGoogle(Request $request)
    {   
        $provider = "google";
        $token = $request->token;
        $providerUser = Socialite::driver($provider)->userFromToken($token);
        $customer = Customer::where('provider_name', $provider)->where('provider_id', $providerUser->id)->first();

        if($customer){
            $accessToken = $customer->createToken('syclecommerce')->accessToken;
            $data = [
                'message' => 'Successfully Login',
                'access_token' => $accessToken,
                'customerData' => $customer,
            ]; 
            return response()->json($data);
        }else{
            return response()->json([
                'message'   =>  'Sorry, You are not registered.!!'
            ], 500);
        }

    } 


/* ---------------- Facebook Section --------------------- */

     /* -------facebook register --------- */
     public function socialRegisterFacebook(Request $request)
     {   
         $provider = "facebook";
         $token = $request->token;
         $first_name = $request->first_name;
         $last_name = $request->last_name;
         $email = $request->email;
         $phone_number = $request->phone_number;
         $date_of_birth = $request->date_of_birth;
 
         $providerUser = Socialite::driver($provider)->userFromToken($token);

         if($providerUser->email === $email){
            $customer = Customer::where('provider_name', $provider)->where('provider_id', $providerUser->id)->first();
    
            if($customer == null){
                $data = customer::create([
                    'provider_name' => $provider,
                    'provider_id' => $providerUser->id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'date_of_birth' => $date_of_birth,
                ]);
    
                $customerData = Customer::where('id', $data->id)->first();
                $accessToken = $customerData->createToken('syclecommerce')->accessToken;
    
                $data = [
                    'message' => 'Successfully Register Account',
                    'access_token' => $accessToken,
                    'customerData' => $customerData,
                ]; 
                return response()->json($data);
    
            }else{
                return response()->json([
                    'message'   =>  'All Ready Exist Customer.!'
                ], 500);
            }

        }else{
            return response()->json([
                'message'   =>  'Email Not Match.!'
            ], 500);
        }
 
     }

 
 
     /* -------facebook login --------- */
      public function socialLoginFacebook(Request $request)
     {   
         $provider = "facebook";
         $token = $request->token;
         $providerUser = Socialite::driver($provider)->userFromToken($token);
         $customer = Customer::where('provider_name', $provider)->where('provider_id', $providerUser->id)->first();
 
         if($customer){
             $accessToken = $customer->createToken('syclecommerce')->accessToken;
             $data = [
                 'message' => 'Successfully Login',
                 'access_token' => $accessToken,
                 'customerData' => $customer,
             ]; 
             return response()->json($data);
         }else{
             return response()->json([
                 'message'   =>  'Sorry, You are not registered.!!'
             ], 500);
         }
 
     } 


/* ---------------- Apple Section --------------------- */
     
      /* -------Apple register --------- */
      public function socialRegisterApple(Request $request)
      {  
        $provider = "apple";
        $identityToken = $request->identityToken;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $phone_number = $request->phone_number;
        $date_of_birth = $request->date_of_birth;

        $tokenMacth = Customer::where('provider_id', $identityToken)->first();

           if($tokenMacth == null){
            $emailMacth = Customer::where('email', $email)->first();
            if($emailMacth == null){

                $data = customer::create([
                    'provider_name' => $provider,
                    'provider_id' => $identityToken,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'date_of_birth' => $date_of_birth,
                ]);
    
                $customerData = Customer::where('id', $data->id)->first();
                $accessToken = $customerData->createToken('syclecommerce')->accessToken;
    
                $data = [
                    'message' => 'Successfully Register Account',
                    'access_token' => $accessToken,
                    'customerData' => $customerData,
                ]; 
                return response()->json($data);

            }else{
                return response()->json([
                    'message'   =>  'All Ready Exist Customer.!'
                ], 500);
            }

           }else{
               return response()->json([
                   'message'   =>  'All Ready Exist Customer.!'
               ], 500);
           }

      }


      /* -------Apple login --------- */
      public function socialLoginApple(Request $request)
     {   
         $provider = "apple";
         $identityToken = $request->identityToken;
         $customer = Customer::where('provider_id', $identityToken)->first();
 
         if($customer){
             $accessToken = $customer->createToken('syclecommerce')->accessToken;
             $data = [
                 'message' => 'Successfully Login',
                 'access_token' => $accessToken,
                 'customerData' => $customer,
             ]; 
             return response()->json($data);
         }else{
             return response()->json([
                 'message'   =>  'Sorry, You are not registered.!!'
             ], 500);
         }
 
     } 


}
