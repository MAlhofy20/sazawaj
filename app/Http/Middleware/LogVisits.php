<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;



use Closure;

class LogVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        // Log the visit to the database
        // DB::table('visits')->insert([
        //     'user_id' => auth()->check() ? auth()->id() : null,
        //     'visitor_ip' => $request->ip(),
        //     'url' => $request->url(),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        return $next($request);
    }

}
