<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Country;
use Illuminate\Http\Request;

class countryController extends Controller
{
    #index
    public function index()
    {
        $data = Country::orderBy('title_ar', 'asc')->get();
        return view('dashboard.countrys', compact('data'));
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

        #store new country
        Country::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة الدولة ' . $request->title_ar);

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

        #update country
        Country::whereId($request->id)->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل الدولة ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get country
        $country = Country::whereId($request->id)->firstOrFail();
        $title_ar = $country->title_ar;

        #send FCM

        #delete country
        $country->delete();

        #add adminReport
        admin_report('حذف الدولة ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get countrys
        if ($type == 'all') $countrys = Country::get();
        else {
            $ids = $request->country_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $country_ids    = explode(',', $second_ids);
            $countrys = Country::whereIn('id', $country_ids)->get();
        }

        foreach ($countrys as $country) {
            #send FCM

            #delete country
            $country->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من دولة');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
