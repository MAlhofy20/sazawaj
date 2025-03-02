<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Slider;
use Illuminate\Http\Request;

class sliderController extends Controller
{
    #index
    public function index($type)
    {
        $data = Slider::whereType($type)->get();
        return view('dashboard.sliders', compact('data' , 'type'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url'          => 'nullable',
            'desc_ar'      => 'nullable',
            'desc_en'      => 'nullable',
            'photo'        => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sliders')]);
        #store new slider
        $slider = Slider::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة اعلان');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url'          => 'nullable',
            'desc_ar'      => 'nullable',
            'desc_en'      => 'nullable',
            'photo'        => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sliders')]);
        #update slider
        $slider = Slider::whereId($request->id)->first();
        $slider->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل اعلان');

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get slider
        $slider = Slider::whereId($request->id)->firstOrFail();

        #send FCM

        #delete slider
        $slider->delete();

        #add adminReport
        admin_report('حذف اعلان');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get sliders
        if ($type == 'all') $sliders = Slider::get();
        else {
            $ids = $request->slider_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $slider_ids = explode(',', $second_ids);
            $sliders = Slider::whereIn('id', $slider_ids)->get();
        }

        foreach ($sliders as $slider) {
            #send FCM

            #delete slider
            $slider->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من اعلان');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
