<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Shipping_type;
use Illuminate\Http\Request;

class shipping_typeController extends Controller
{
    #index
    public function index()
    {
        $data = Shipping_type::orderBy('title_ar', 'asc')->get();
        return view('dashboard.shipping_types', compact('data'));
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

        #store new shipping_type
        Shipping_type::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة طريقة الشحن ' . $request->title_ar);

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

        #update shipping_type
        Shipping_type::whereId($request->id)->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل طريقة الشحن ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get shipping_type
        $shipping_type = Shipping_type::whereId($request->id)->firstOrFail();
        $title_ar = $shipping_type->title_ar;

        #send FCM

        #delete shipping_type
        $shipping_type->delete();

        #add adminReport
        admin_report('حذف طريقة الشحن ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get shipping_types
        if ($type == 'all') $shipping_types = Shipping_type::get();
        else {
            $ids = $request->shipping_type_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $shipping_type_ids    = explode(',', $second_ids);
            $shipping_types = Shipping_type::whereIn('id', $shipping_type_ids)->get();
        }

        foreach ($shipping_types as $shipping_type) {
            #send FCM

            #delete shipping_type
            $shipping_type->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من طريقة شحن');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
