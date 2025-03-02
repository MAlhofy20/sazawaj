<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Validator;
use App\Models\Rate;
use Illuminate\Http\Request;

class rateController extends Controller
{
    #index
    public function index()
    {
        $data = Rate::latest()->get();
        return view('dashboard.rates', compact('data'));
    }

    #delete one
    public function delete(Request $request)
    {
        #get client
        $rate = Rate::whereId($request->id)->firstOrFail();

        #send FCM

        #delete client
        $rate->delete();

        #add adminReport
        admin_report('حذف التقييم ');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get clients
        if ($type == 'all') $rates = Rate::get();
        else {
            $ids = $request->rate_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $rate_ids    = explode(',', $second_ids);
            $rates = Rate::whereIn('id', $rate_ids)->get();
        }

        foreach ($rates as $rate) {
            #send FCM

            #delete client
            $rate->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من تقييم');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    public function seen_rate(Request $request)
    {
        //check data
        $rate = Rate::whereId($request->id)->first();
        if (!isset($rate)) return 0;
        //update data
        $rate->seen = $rate->seen == 1 ? 0 : 1;
        $rate->save();

        //add report
        $rate->seen ? admin_report(' اظهار التقييم ') : admin_report('ألغاء اظهار التقييم ');
        $msg = $rate->seen ? Translate('ظاهر') : Translate('مخفي');
        return $msg;
    }
}
