<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\City;
use Illuminate\Http\Request;

class cityController extends Controller
{
    #index
    public function index()
    {
        $data = City::orderBy('title_ar', 'asc')->get();
        return view('dashboard.citys', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id'    => 'nullable|exists:countries,id',
            'title_ar'      => 'required|max:255',
            'title_en'      => 'nullable|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new city
        City::create($request->except(['_token']));

        #add siteReport
        site_report('أضافة المدينة ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id'    => 'nullable|exists:countries,id',
            'title_ar'      => 'required|max:255',
            'title_en'      => 'nullable|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update city
        City::whereId($request->id)->update($request->except(['_token']));

        #add siteReport
        site_report('تعديل المدينة ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get city
        $city = City::whereId($request->id)->firstOrFail();
        $title_ar = $city->title_ar;

        #send FCM

        #delete city
        $city->delete();

        #add siteReport
        site_report('حذف المدينة ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get citys
        if ($type == 'all') $citys = City::get();
        else {
            $ids = $request->city_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $city_ids    = explode(',', $second_ids);
            $citys = City::whereIn('id', $city_ids)->get();
        }

        foreach ($citys as $city) {
            #send FCM

            #delete city
            $city->delete();
        }

        #add siteReport
        site_report('حذف اكتر من مدينة');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
