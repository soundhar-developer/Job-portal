<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRecruiter
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
            return redirect(route('login'));
        }

        if ($user->user_type == "recruiter") {
            return $next($request);
        }
        return redirect('/jobseeker/dashboard');
    }
}
