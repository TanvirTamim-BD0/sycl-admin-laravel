<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Auth;
use Hash;
use Carbon\Carbon;
use Validator;
use Session;

class ProfileController extends Controller
{
    public function index(){
    	return view('backend.profile.index');
    }

     public function update(Request $request, $id)
    {   
    	$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();
        return redirect(route('profile'))->with('message','Successfully Brand Added');;
    }


    public function security()
    {
    	return view('backend.profile.security');
    }

    public function securityUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        $current_user = Auth()->user();

        if (Hash::check($request->old_password,$current_user->password)) {

            if ($request->new_password == $request->confirm_password) {

                User::find($current_user->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);

                Auth::logout();
                return Redirect()->route('login');

            }else{
                return redirect()->route('security')->with('error','Password and Confirm Password do not match');
            }

        }else{
            return redirect()->route('security')->with('error','Old Password do not match !');
        }
    }
}
