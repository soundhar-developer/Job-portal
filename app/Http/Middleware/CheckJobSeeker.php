<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckJobSeeker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!auth()->check()) {
            return redirect('/login');
        }

        if ($user->user_type == "job_seeker") {
            return $next($request);
        }
        return redirect('/recruiter/dashboard');
    }
}
