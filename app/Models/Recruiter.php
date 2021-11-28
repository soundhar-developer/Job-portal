<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruiter extends Model
{
    use HasFactory;

    protected $table = 'recruiter';

    protected $fillable = [
         'company_name', 'password' ,'phone', 'email', 'address'
    ];
}
