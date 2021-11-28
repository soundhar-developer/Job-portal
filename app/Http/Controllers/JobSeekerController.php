<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\JobSeeker;
use App\Models\User;
use App\Models\Job;
use App\Models\Recruiter;
use App\Models\AppliedJob;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Mail;

class JobSeekerController extends Controller
{
    /*
    ** Fetch job location
    */
    public function getJobLocation() {
    	$location = Location::all();
    	return response()->json(['data' => $location]);
    }

    /*
    ** Create job seeker
    */
    public function store(Request $request) {
    	DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $data = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'experience' => $request->get('experience'),
                'notice_period' => $request->get('notice_period'),
                'skills' => $request->get('skills'),
                'location' => $request->get('location'),
                'password' => Hash::make($request->get('password'))
            ];

            $checkMail = JobSeeker::where('email', $request->get('email'))->first();
            if($request->get('password') != $request->get('confirm_password')) {
                $response['success'] = false;
                $response['message'] = "Confirm password is mismatched!";
            } else if($checkMail) {
                $response['success'] = false;
                $response['message'] = "Email has been already used!";
            } else {
                $jobSeeker = JobSeeker::create($data);
                if($jobSeeker) {
                    $userData = [
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'user_type_id' => $jobSeeker->id,
                        'user_type' => "job_seeker",
                        'password' => Hash::make($request->get('password'))
                    ];
                    $createUser = User::create($userData);
                }
                DB::commit(); 
                if($jobSeeker) {
                    $response['success'] = true;
                    $response['message'] = "Account has been created successfully!";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Something went wrong!";
                }
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
    ** Search active jobs
    */
    public function searchActiveJob(Request $request) {
        DB::beginTransaction();
        try {
           $job = Job::where('skills_required' , $request->get('skills'))->where('location', $request->get('location'))->whereBetween('experience', [$request->get('min_experience'), $request->get('max_experience')])->with('recruiter')->get();
           $data = [];
           foreach ($job as $key => $value) {
                if( $value['recruiter']->company_name == $request->get('company_name') ) {
                    array_push($data, $job[$key]);
                }
            } 
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $data['success'] = false;
            $data['message'] = "Something went wrong!";
        }

        return response()->json(['data' => $data]);
    }

    /*
    ** Apply job
    */
    public function applyJob($jobId, $recruiterid) {
        DB::beginTransaction();
        try {
            $jobSeeker = JobSeeker::where('id', Session::get('user')->user_type_id)->first();
            $job = job::find($jobId);
            $data = [
                'canditate_name' => $jobSeeker->name,
                'experience' => $jobSeeker->experience,
                'phone' => $jobSeeker->phone,
                'job_id' => $job->id,
                'recruiter_id' => $recruiterid,
                'job_title' => $job->job_title,
                'resume' => $jobSeeker->resume,
                'photo' => $jobSeeker->photo,

            ];
            $appliedJob = AppliedJob::create($data);
            if($appliedJob) {
                $statusApply = [
                    'apply_status' => 'Applied'
                ];
                $job->fill($statusApply);
                $job->save();   
                $recruiter = Recruiter::where('id', $recruiterid)->first();
                $mailData = [
                  'subject' => "Regarding applied job.",
                  'email' => $recruiter->email,
                  'content' => $jobSeeker->name ." has been applied for ".$appliedJob->job_title ." job."
                ];

                // send mail through jobs

                dispatch(new \App\Jobs\SendEmailJob($mailData));

                
                // send mail

                // Mail::send('mail.applyjobmail', $mailData, function($message) use ($mailData) {
                //     $message->to($mailData['email'])->subject($mailData['subject']);
                // }); 

                DB::commit();
                $response['success'] = true;
                $response['status'] = "Applied";
                $response['message'] = "Job has been applied successfully";
            } else {
                $response['success'] = false;
                $response['message'] = "Something went wrong!";
            }
        } catch(\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
            $response['success'] = false;
            $response['message'] = "Something went wrong!";
        }

        return response()->json(['data' => $response]); 
    }


}
