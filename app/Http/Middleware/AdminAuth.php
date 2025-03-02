<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        #remove old session danger
        Session::forget('danger');
        //if user not login
        if (Auth::guest()) return redirect()->route('admin_login');
        //if user isn't superAdmin
        if (Auth::user()->user_type != 'superAdmin' && Auth::user()->user_type != 'admin') {
            $msg = Translate('لا تملك الصلاحية للدخول');
            if ($request->ajax()) return response()->json(['value' => 0, 'msg' => $msg]);
            Session::put('danger', $msg);
            return redirect()->route('admin_login');
        }

        return $next($request);
    }
}
