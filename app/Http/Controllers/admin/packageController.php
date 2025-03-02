<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Package;
use Illuminate\Http\Request;

class packageController extends Controller
{
    #index
    public function index()
    {
        $data = Package::orderBy('id', 'asc')->get();
        return view('dashboard.packages', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            //'title_en' => 'required',
            'price_with_value'    => 'required',
            //'desc_ar'  => 'required',
            //'desc_en'  => 'required',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new bank account
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sliders')]);
        $value_added = (float) settings('value_added') / 100;
        $request->request->add([
            'price' => round($request->price_with_value - ($request->price_with_value / (1 + $value_added) * $value_added), 2),
        ]);
        Package::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة باقة ');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #edit
    public function edit($id)
    {
        $data = Package::whereId($id)->firstOrFail();
        return view('dashboard.packages_edit', compact('data'));
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            //'title_en' => 'required',
            'price_with_value'    => 'required',
            //'desc_ar'  => 'required',
            //'desc_en'  => 'required',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update client
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sliders')]);
        $package = Package::whereId($request->id)->first();
        $value_added = (float) settings('value_added') / 100;
        $request->request->add([
            'price' => round($request->price_with_value - ($request->price_with_value / (1 + $value_added) * $value_added), 2),
        ]);
        $package->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل باقة ');

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return redirect('packages');
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get package
        $package = Package::whereId($request->id)->firstOrFail();
        $title = $package->title;

        #send FCM

        #delete package
        $package->delete();

        #add adminReport
        admin_report('حذف باقة ');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get packages
        if ($type == 'all') $packages = Package::get();
        else {
            $ids = $request->package_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $package_ids    = explode(',', $second_ids);
            $packages = Package::whereIn('id', $package_ids)->get();
        }

        foreach ($packages as $package) {
            #delete package
            $package->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من باقة');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}