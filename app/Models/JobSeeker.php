<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

    protected $table = 'job_seeker';

    protected $fillable = [
        'name', 'email', 'password','phone', 'experience', 'notice_period', 'skills', 'location', 'resume', 'photo'
    ];
}
