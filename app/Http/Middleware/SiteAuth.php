<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class SiteAuth
{
    public function handle($request, Closure $next)
    {
        //if user not login
        if (Auth::guest()) {
            $msg = Translate('قم بتسجيل دخولك اولا');
            if($request->ajax()) return response()->json(['value' => 2, 'msg' => $msg]);
            Session::put('danger' , $msg);
            return redirect()->route('site_login');
        }
        //if user not active
        /*elseif (Auth::user()->active != '1') {
            $msg = Translate('قم بتفعيل حسابك');
            if($request->ajax()) return response()->json(['value' => 3, 'msg' => $msg]);
            Session::put('danger' , $msg);
            return redirect()->route('site_active');
        }*/
        //if user blocked
        elseif (Auth::user()->blocked != '0') {
            $msg = Translate('قم بمراجعة حسابك مع الادارة');
            Auth::logout();
            if($request->ajax()) return response()->json(['value' => 2, 'msg' => $msg]);
            Session::put('danger' , $msg);
            return redirect()->route('site_contact');
        }
        //if user not confirm
        elseif (Auth::user()->confirm != '1') {
            $msg = Translate('في انتظار تفعيل حسابك من قبل الادارة');
            Auth::logout();
            if($request->ajax()) return response()->json(['value' => 2, 'msg' => $msg]);
            Session::put('danger' , $msg);
            return redirect()->route('site_login');
        }
        //if user not compelete
        // elseif (Auth::user()->compelete != '1') {
        //     $msg = Translate('قم باكمال بياناتك');
        //     if($request->ajax()) return response()->json(['value' => 4, 'msg' => $msg]);
        //     Session::put('danger' , $msg);
        //     return redirect()->route('site_profile');
        // }

        return $next($request);
    }
}
