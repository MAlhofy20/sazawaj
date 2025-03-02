<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Session;

class hasPermission
{
    public function handle($request, Closure $next)
    {
        #remove old session danger
        Session::forget('danger');
        //if user not login
        if (Auth::guest()) return redirect()->route('admin_login');
        //if user isn't superAdmin
        if (Auth::id() == 1 || hasPermission(Route::currentRouteName()))
            return $next($request);

        $msg = 'لا تملك الصلاحية';
        if ($request->ajax()) return response()->json(['value' => 0, 'msg' => $msg]);
        return back()->with('danger', $msg);
    }
}
