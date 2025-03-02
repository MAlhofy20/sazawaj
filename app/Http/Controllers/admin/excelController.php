<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Validator;
use App\Models\User;
use App\Models\City;
use App\Models\Country;
use App\Models\Section;
use App\Models\Order;
use App\Models\Order_provider;
use App\Models\Order_item;
use App\Models\Upload_image;
use Carbon\Carbon;
use Excel;
use App\Imports\ServiceImports;

class excelController extends Controller
{
    public function excel_upload()
    {
        $data = [
            'images' => Upload_image::orderBy('id','desc')->get(),
        ];
        return view('dashboard.excel_upload', $data);
    }

    public function post_upload_excel_order(Request $request)
    {
        $validator = Validator::make($request->all(), ['excel_sheet'  => 'required|mimes:xls,xlsx']);
        if ($validator->fails()) return back()->withErrors($validator);

        try {
            Session::put('request', $request->all());
            $file = upload_image($request->file('excel_sheet'), 'public/images/sliders');
            Excel::import(new ServiceImports, ltrim($file , '/'));
            dd(Translate('تم بنجاح'));

            session()->flash('success', Translate('تم بنجاح'));
            return back();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    #post_upload_image
    public function post_upload_image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'        => 'required',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sliders')]);
        #store new image
        $image = Upload_image::create($request->except(['_token', 'photo']));

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }
}
