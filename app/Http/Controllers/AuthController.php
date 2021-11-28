<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Mail;

class AuthController extends Controller
{
    /*
    ** Login user
    */
    public function login(Request $request)
    {
        try {
            request()->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $request->get('email'))->first();
            if (Auth::attempt($credentials)) {
                // Authentication passed...
                Session::put('user', $user);
                $data['success'] = true;
                $data['message'] = "Logged in successfully!";
                $data['id'] = $user->id;
                $data['name'] = $user->name;
                $data['user_type'] = $user->user_type;
            } else if ( $user->password != Hash::make($request->get('password')) || $user->email != $request->get('email') ) {
                $data['success'] = false;
                $data['message'] = "Email/password is incorrect.";
            } else {
                $data['success'] = false;
                $data['message'] = "Invalid Email.If you are not register please signup.";
            }
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            $data['success'] = false;
            $data['message'] = "Invalid Email.If you are not register please signup.";
        }
        return response()->json(['data' => $data]);
    }

    /*
    ** Logout user
    */
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
