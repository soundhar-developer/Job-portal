<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recruiter;
use App\Models\User;
use App\Models\Job;
use App\Models\JobSeeker;
use App\Models\AppliedJob;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Mail;

class RecruiterController extends Controller
{
    /*
    ** Create recruiter
    */
    public function store(Request $request) {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required',
                'confirm_password' => 'required',
            ]);

            if ($validator->fails()) {
                Session::flash('error', $validator->messages()->first());
                return redirect()->back()->withInput();
           }

            $data = [
                'company_name' => $request->get('company_name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'password' => Hash::make($request->get('password'))
            ];

            $checkMail = Recruiter::where('email', $request->get('email'))->first();

            if($request->get('password') != $request->get('confirm_password')) {
                Session::flash('error', 'Confirm password is mismatched!');
                return redirect()->back()->withInput();
            } else if($checkMail) {
                Session::flash('error', 'Email has been already used!');
                return redirect()->back()->withInput();
            } else {
                $recruiter = Recruiter::create($data);
                if($recruiter) {
                    $userData = [
                        'name' => $request->get('company_name'),
                        'email' => $request->get('email'),
                        'user_type' => 'recruiter',
                        'user_type_id' => $recruiter->id,
                        'password' => Hash::make($request->get('password'))
                    ];
                    $createUser = User::create($userData);
                }
            }
        return redirect('/login');
    }

    /*
    ** Create job
    */
    public function addJob(Request $request) {
        DB::beginTransaction();
        $request->request->add(['recruiter_id' => Session::get('user')->user_type_id]);
        try {
            $addJob = Job::create($request->all());
            if($addJob) {
                DB::commit();
                $response['success'] = true;
                $response['message'] = "Job has been created successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Something went wrong!";
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }

        return response()->json(['data' => $response]);
    }

    /*
    ** Edit job
    */
    public function editJob(Request $request) {
        DB::beginTransaction();
        try {
            $editJob = Job::find($request->get('id'));
            if($editJob) {
                $editJob->fill($request->all());
                $editJob->save(); 
                DB::commit();
                $response['success'] = true;
                $response['message'] = "Job has been updated successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Something went wrong!";
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }

        return response()->json(['data' => $response]);
    }

    /*
    ** Delete job.
    */
    public function deleteJob(Request $request) {
        DB::beginTransaction();
        try {
            $job = Job::find($request->get('id'));
            if($job) {
                $job->delete();
                DB::commit();
                $response['success'] = true;
                $response['message'] = "Job has been deleted successfully";
            } else {
                $response['success'] = false;
                $response['message'] = "This data is not available.";
            }
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }

        return response()->json(['data' => $response]);
    }

    /*
    ** Filter candidate
    */
    public function filterCandidate(Request $request) {
        if($request->get('skills') != '' && $request->get('location') != '' && $request->get('min_experience') != '' && $request->get('max_experience') != '' && $request->get('notice_period') != '') {
            $data = JobSeeker::where('skills' , $request->get('skills'))->where('location', $request->get('location'))->where('notice_period', $request->get('notice_period'))->whereBetween('experience', [$request->get('min_experience'), $request->get('max_experience')])->get();
        } else {
            $data = JobSeeker::orWhere('skills' , $request->get('skills'))->orWhere('location', $request->get('location'))->orWhere('notice_period', $request->get('notice_period'))->orWhereBetween('experience', [$request->get('min_experience'), $request->get('max_experience')])->get();
        }
        return response()->json(['data' => $data]);
    }

    /*
    ** Get all job
    */
    public function getAllJob() {
        $job = Job::where('recruiter_id', Session::get('user')->user_type_id)->get();
        return response()->json(['data' => $job]);
    } 


    /*
    ** Get all candidate
    */
    public function getAllCandidate() {
        $jobSeeker = JobSeeker::all();
        return response()->json(['data' => $jobSeeker]);
    } 

    /*
    ** Get all applied job
    */
    public function getAllAppliedJob() {
        $appliedJob = AppliedJob::where('recruiter_id', Session::get('user')->user_type_id )->get();
        return response()->json(['data' => $appliedJob]);
    } 

    /*
    ** Get all active job
    */
    public function getActiveJob() {
        $job = Job::where('status', 'Active')->with('recruiter')->get();
        return response()->json(['data' => $job]);
    }

    /*
    ** Fetch job by id
    */
    public function fetchJob($jobId) {
        $job = Job::where('id', $jobId)->first();
        return response()->json(['data' => $job]);
    }
}
