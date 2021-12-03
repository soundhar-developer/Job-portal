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
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                Session::flash('error', $validator->messages()->first());
                return redirect()->back()->withInput();
            }

            $credentials = $request->only('email', 'password');
            $user = User::where('email', $request->get('email'))->first();
            
            if (!$user) {
                Session::flash('error', 'Invalid Email.If you are not register please signup.');
                return redirect()->back()->withInput();
            }

            if (Auth::attempt($credentials)) {
                // Authentication passed...
                Session::put('user', $user);
                $data['success'] = true;
                $data['message'] = "Logged in successfully!";
                $data['id'] = $user->id;
                $data['name'] = $user->name;
                $data['user_type'] = $user->user_type;
            } else {
                Session::flash('error', 'Email/Password is incorrect.');
                return redirect()->back()->withInput();
            }

            if($user->user_type == "job_seeker") {
                return redirect('/jobseeker/dashboard');
            } else {
                return redirect('/recruiter/dashboard');
            }
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
