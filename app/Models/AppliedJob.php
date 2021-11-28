<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedJob extends Model
{
    use HasFactory;

    protected $table = 'applied_job';

    protected $fillable = [
        'photo', 'canditate_name', 'experience', 'phone', 'job_title', 'resume', 'recruiter_id', 'job_id'
    ];
}
