<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class Lang
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
        Session::has('language') ? App::setLocale(Session('language')) : App::setLocale('ar');
        Session::has('language') ? Carbon::setLocale(Session('language')) : Carbon::setLocale('ar');
        $data = Session::has('language') ? Session('language') : 'ar';
        View::share('lang', $data);
        return $next($request);
    }
}
