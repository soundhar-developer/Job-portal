<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job';

    protected $fillable = [
        'job_description', 'recruiter_id', 'skills_required', 'experience', 'status', 'job_title', 'location', 'apply_status'
    ];

    public function recruiter() {
        return $this->hasOne('App\Models\Recruiter','id','recruiter_id');
    }

    public function appliedjob() {
        return $this->hasOne('App\Models\AppliedJob','job_id','id');
    }
}
