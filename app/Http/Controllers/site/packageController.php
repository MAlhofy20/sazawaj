<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;

class packageController extends Controller
{
    #index
    public function index($type, $id)
    {
        $data = Package::whereUserId($id)->whereType($type)->get();
        return view('site.packages', compact('data', 'type', 'id'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'desc_en'  => 'required',
            'desc_en'  => 'required',
            'amount'   => 'required',
            'price'    => 'required',
            'photo'    => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/packages')]);
        if($request->has('start_time') && !empty($request->start_time)) {
            $start_time = Carbon::parse($request->start_time)->format('H:i:s');
            $end_time   = Carbon::parse($request->start_time)
                ->addMinutes((int) $request->amount)
                ->format('H:i:s');

            $request->request->add([
                'start_time' => $start_time,
                'end_time'   => $end_time,
                'end_date'   => Carbon::parse($request->date . $start_time)
            ]);
        }
        #store new package
        Package::create($request->except(['_token', 'photo']));

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'desc_en'  => 'required',
            'desc_en'  => 'required',
            'amount'   => 'required',
            'price'    => 'required',
            'photo'    => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/packages')]);
        if ($request->has('start_time') && !empty($request->start_time)) {
            $start_time = Carbon::parse($request->start_time)->format('H:i:s');
            $end_time   = Carbon::parse($request->start_time)
                ->addMinutes((int) $request->amount)
                ->format('H:i:s');

            $request->request->add([
                'start_time' => $start_time,
                'end_time'   => $end_time,
                'end_date'   => Carbon::parse($request->date . $start_time)
            ]);
        }
        #update package
        $package = Package::whereId($request->id)->first();
        $package->update($request->except(['_token', 'photo']));

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get package
        $package = Package::whereId($request->id)->firstOrFail();

        #send FCM

        #delete package
        $package->delete();

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
            $package_ids = explode(',', $second_ids);
            $packages = Package::whereIn('id', $package_ids)->get();
        }

        foreach ($packages as $package) {
            #send FCM

            #delete package
            $package->delete();
        }

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
