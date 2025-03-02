<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Our_location;
use Illuminate\Http\Request;

class our_locationController extends Controller
{
    #index
    public function index()
    {
        $data = Our_location::orderBy('title', 'asc')->get();
        return view('dashboard.our_locations', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new our_location
        Our_location::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة موقع ' . $request->title);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update our_location
        Our_location::whereId($request->id)->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل موقع ' . $request->title);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get our_location
        $our_location = Our_location::whereId($request->id)->firstOrFail();
        $title = $our_location->title;

        #send FCM

        #delete our_location
        $our_location->delete();

        #add adminReport
        admin_report('حذف موقع ' . $title);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get our_locations
        if ($type == 'all') $our_locations = Our_location::get();
        else {
            $ids = $request->our_location_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $our_location_ids    = explode(',', $second_ids);
            $our_locations = Our_location::whereIn('id', $our_location_ids)->get();
        }

        foreach ($our_locations as $our_location) {
            #send FCM

            #delete our_location
            $our_location->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من موقع');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
