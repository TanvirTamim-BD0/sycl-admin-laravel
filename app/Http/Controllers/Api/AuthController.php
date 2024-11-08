<?php

namespace App\Http\Controllers\Api;

use Session;
use Carbon\Carbon;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Mail;

class AuthController extends Controller
{   

    //To Customer Login...
    public function login(Request $request)
     {
         $request->validate([
             'email' => 'required',
             'password' => 'required',
         ]);
 
         $customer = Customer::where('email', $request->email)->first();
         if ($customer) {
             if (Hash::check($request->password, $customer->password)) {
                    $tokenData = $customer->createToken('syclecommerce');
                    $token = $tokenData->token;
 
                    if($token->save()){
                        $data = [
                            'message' => 'successfully login',
                            'access_token' => $tokenData->accessToken,
                            'customerData' => $customer
                        ];
 
                         return response()->json($data);
                     }
             }else {
                 return response()->json([
                     'message'   =>  'Sorry, Password not matching.!'
                 ], 500);
             }
         }
         else {
             return response()->json([
                 'message'   =>  'Sorry, You are not registered.!'
             ], 500);
         }
     }



    //To Customer Register...
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        $data = $request->all();

        if(!Customer::where('email', $request->email)->first()){
                $data['password'] = Hash::make($request->password);

                if($newCustomer = Customer::create($data)){
                    $customerData = Customer::where('email', $request->email)->first();
                    $accessToken = $customerData->createToken('syclecommerce')->accessToken;

                     $data = [
                        'message' => 'Successfully Register Account',
                        'access_token' => $accessToken,
                        'customerData' => $customerData,
                    ]; 

                    return response()->json($data);
                }else{
                    return response()->json([
                        'message'   =>  'Something is wrong.!'
                    ], 500);
                }
        }else{
            return response()->json([
                'message'   =>  'This Email had already taken.!'
            ], 500);
        }
    }


    //To logout...
     public function logout(Request $request)
     {
         $request->user()->token()->revoke();
         return response()->json([
             'message' => 'successfully logout'
         ]);
     }


    
     //To Reset Password...
    public function otpGenerate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        $verifyCode = rand(100000, 999999);
            
        $mail_data = [
                'email' => $request->email,
                'from_name' => 'wisdomokwodu@sycl.shop',
                'verify_code' =>  $verifyCode,
                'subject' => 'Verify Email Address',
        ];
    
        \Mail::send('backend.email-template',$mail_data,function($message) use ($mail_data){
            $message->to($mail_data['email'])
                    ->from($mail_data['from_name'])
                    ->subject($mail_data['subject']);
            });
        
        $data = [
            'verify_code' => $verifyCode,
        ];

             return response()->json($data);
    }


    //To password update...
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if($customer){
            $customer->password = Hash::make($request->password);
            $customer->save();

            return response()->json([
                'message' => 'Password changed successfully, Please login.',
            ], 201);

        }else{
            return response()->json([
                'message'   =>  'email account not found.'
            ], 500);
        }
        
    }


     //To get profile data ...
    public function getProfileData(Request $request)
    {
        $profileData = Customer::where('id', Auth::user()->id)->first();
        if(!empty($profileData)){
            return response()->json([
                'message'   =>  'success',
                'profileData'   =>  $profileData
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }


    // changed password ......
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        $currentCustomer = Customer::where('id', Auth::user()->id)->first();
        if (Hash::check($request->current_password,$currentCustomer->password)) {

                Customer::find($currentCustomer->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return response()->json([
                    'message'   =>  'successfully password changed',
                ], 201);

        }else{
            return response()->json([
                'message'   =>  'Current Password do not match.',
            ], 500);
        }
    }

    
    // profile data update .............
    public function profileDataUpdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required'
        ]);

        $data = $request->all();
        $customerData = Customer::where('id', Auth::user()->id)->first();
        
        if($customerData->update($data)){
            return response()->json([
                'message' => 'successfully profile updated',
                'customerData'   =>  $customerData
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.'
            ], 500);
        }
    }


    // delete customer account .............
    public function deleteAccount()
    {
        $customer = Customer::where('id', Auth::user()->id)->first();
        
        if($customer->delete()){
            return response()->json([
                'message' => 'successfully delete account',
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.'
            ], 500);
        }
    }
    

}
