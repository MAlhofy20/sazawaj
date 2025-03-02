<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Order_time;
use Illuminate\Http\Request;

class order_timeController extends Controller
{
    #index
    public function index()
    {
        $data = Order_time::orderBy('title_ar', 'asc')->get();
        return view('dashboard.order_times', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'      => 'required|max:255',
            'title_en'      => 'nullable|max:255',
            'code'          => 'nullable',
            'currency'      => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new order_time
        Order_time::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة اوقات العمل ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'      => 'required|max:255',
            'title_en'      => 'nullable|max:255',
            'code'          => 'nullable',
            'currency'      => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update order_time
        Order_time::whereId($request->id)->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل اوقات العمل ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get order_time
        $order_time = Order_time::whereId($request->id)->firstOrFail();
        $title_ar = $order_time->title_ar;

        #send FCM

        #delete order_time
        $order_time->delete();

        #add adminReport
        admin_report('حذف اوقات العمل ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get order_times
        if ($type == 'all') $order_times = Order_time::get();
        else {
            $ids = $request->order_time_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $order_time_ids    = explode(',', $second_ids);
            $order_times = Order_time::whereIn('id', $order_time_ids)->get();
        }

        foreach ($order_times as $order_time) {
            #send FCM

            #delete order_time
            $order_time->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من وقت عمل');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
