<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Unit;
use Illuminate\Http\Request;

class unitController extends Controller
{
    #index
    public function index()
    {
        $data = Unit::orderBy('id', 'asc')->get();
        return view('dashboard.units', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new bank account
        $unit = Unit::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة وحدة قياس ' . $request->title);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update client
        $unit = Unit::whereId($request->id)->first();
        $unit->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل وحدة قياس ' . $request->title);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get unit
        $unit = Unit::whereId($request->id)->firstOrFail();
        $title = $unit->title;

        #send FCM

        #delete unit
        $unit->delete();

        #add adminReport
        admin_report('حذف وحدة قياس ' . $title);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get units
        if ($type == 'all') $units = Unit::get();
        else {
            $ids = $request->unit_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $unit_ids    = explode(',', $second_ids);
            $units = Unit::whereIn('id', $unit_ids)->get();
        }

        foreach ($units as $unit) {
            #delete unit
            $unit->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من وحدة قياس');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
