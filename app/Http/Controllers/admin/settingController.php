<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class settingController extends Controller
{
    #index
    public function index()
    {
        return view('dashboard.settings');
    }

    #update
    public function update(Request $request)
    {


        if ($request->hasFile('logo')) {
            $logo = Setting::firstOrCreate(['key' => 'logo']);
            $logo->value = upload_image($request->file('logo'), 'public/images/setting');
            $logo->save();
        }

        if ($request->hasFile('logo_footer')) {
            $logo_footer = Setting::firstOrCreate(['key' => 'logo_footer']);
            $logo_footer->value = upload_image($request->file('logo_footer'), 'public/images/setting');
            $logo_footer->save();
        }

        if ($request->hasFile('logo_map')) {
            $logo_map = Setting::firstOrCreate(['key' => 'logo_map']);
            $logo_map->value = upload_image($request->file('logo_map'), 'public/images/setting');
            $logo_map->save();
        }

        if ($request->hasFile('search_photo')) {
            $search_photo = Setting::firstOrCreate(['key' => 'search_photo']);
            $search_photo->value = upload_image($request->file('search_photo'), 'public/images/setting');
            $search_photo->save();
        }

        if ($request->hasFile('contact_photo')) {
            $contact_photo = Setting::firstOrCreate(['key' => 'contact_photo']);
            $contact_photo->value = upload_image($request->file('contact_photo'), 'public/images/setting');
            $contact_photo->save();
        }

        if ($request->hasFile('about_photo')) {
            $about_photo = Setting::firstOrCreate(['key' => 'about_photo']);
            $about_photo->value = upload_image($request->file('about_photo'), 'public/images/setting');
            $about_photo->save();
        }

        if ($request->hasFile('thanks_photo')) {
            $thanks_photo = Setting::firstOrCreate(['key' => 'thanks_photo']);
            $thanks_photo->value = upload_image($request->file('thanks_photo'), 'public/images/setting');
            $thanks_photo->save();
        }

        if ($request->hasFile('thanks_pay_photo')) {
            $thanks_pay_photo = Setting::firstOrCreate(['key' => 'thanks_pay_photo']);
            $thanks_pay_photo->value = upload_image($request->file('thanks_pay_photo'), 'public/images/setting');
            $thanks_pay_photo->save();
        }

        if (is_array($request->keys)) {
            foreach ($request->keys as $key => $value) {
                $add = Setting::firstOrCreate(['key' => $key]);
                $add->value = $value;
                $add->save();
            }
        }

        #add adminReport
        admin_report('تحديث الإعدادات العامة');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        //return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
        return back();
    }

    #intro
    public function intro(Request $request)
    {


        if ($request->hasFile('first_register_image')) {
            $first_register_image = Setting::firstOrCreate(['key' => 'first_register_image']);
            $first_register_image->value = upload_image($request->file('first_register_image'), 'public/images/setting');
            $first_register_image->save();
        }

        if ($request->hasFile('second_register_image')) {
            $second_register_image = Setting::firstOrCreate(['key' => 'second_register_image']);
            $second_register_image->value = upload_image($request->file('second_register_image'), 'public/images/setting');
            $second_register_image->save();
        }

        if ($request->hasFile('third_register_image')) {
            $third_register_image = Setting::firstOrCreate(['key' => 'third_register_image']);
            $third_register_image->value = upload_image($request->file('third_register_image'), 'public/images/setting');
            $third_register_image->save();
        }

        if ($request->hasFile('fourth_register_image')) {
            $fourth_register_image = Setting::firstOrCreate(['key' => 'fourth_register_image']);
            $fourth_register_image->value = upload_image($request->file('fourth_register_image'), 'public/images/setting');
            $fourth_register_image->save();
        }

        if (is_array($request->keys)) {
            foreach ($request->keys as $key => $value) {
                $add = Setting::firstOrCreate(['key' => $key]);
                $add->value = $value;
                $add->save();
            }
        }

        #add adminReport
        admin_report('تحديث اعدادت ملفات التسجيل');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #social
    public function social(Request $request)
    {
        foreach ($request->keys as $key => $value) {
            $add = Setting::firstOrCreate(['key' => $key]);
            $add->value = $value;
            $add->save();
        }

        #add adminReport
        admin_report('تحديث بيانات مواقع التواصل');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function location(Request $request)
    {
        foreach ($request->keys as $key => $value) {
            $add = Setting::firstOrCreate(['key' => $key]);
            $add->value = $value;
            $add->save();
        }

        #add adminReport
        admin_report('تحديث الخريطة');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #seo
    public function seo(Request $request)
    {
        foreach ($request->keys as $key => $value) {
            $add = Setting::firstOrCreate(['key' => $key]);
            $add->value = $value;
            $add->save();
        }

        #add adminReport
        admin_report('تحديث بيانات محرك البحث');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }
}
