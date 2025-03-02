<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Validator;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class neighborhoodController extends Controller
{
    #index
    public function index()
    {
        $data = Neighborhood::orderBy('title_ar', 'asc')->get();
        return view('dashboard.neighborhoods', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id'       => 'nullable|exists:cities,id',
            'title_ar'      => 'required|max:255',
            'title_en'      => 'nullable|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #city
        $city = City::whereId($request->city_id)->first();

        #store new neighborhood
        Neighborhood::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة المدينة ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id'       => 'nullable|exists:cities,id',
            'title_ar'      => 'required|max:255',
            'title_en'      => 'nullable|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #city
        $city = City::whereId($request->city_id)->first();

        #update neighborhood
        Neighborhood::whereId($request->id)->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل المدينة ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get neighborhood
        $neighborhood = Neighborhood::whereId($request->id)->firstOrFail();
        $title_ar = $neighborhood->title_ar;

        #send FCM

        #delete neighborhood
        $neighborhood->delete();

        #add adminReport
        admin_report('حذف المدينة ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get neighborhoods
        if ($type == 'all') $neighborhoods = Neighborhood::get();
        else {
            $ids = $request->neighborhood_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $neighborhood_ids    = explode(',', $second_ids);
            $neighborhoods = Neighborhood::whereIn('id', $neighborhood_ids)->get();
        }

        foreach ($neighborhoods as $neighborhood) {
            #send FCM

            #delete neighborhood
            $neighborhood->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من مدينة');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
