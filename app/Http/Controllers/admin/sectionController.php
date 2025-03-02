<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Section;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class sectionController extends Controller
{
    #index
    public function index()
    {
        $data = Section::get();
        return view('dashboard.sections', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'          => 'required|max:255',
            'title_en'          => 'nullable|max:255',
            'short_desc_en'     => 'nullable',
            'short_desc_en'     => 'nullable',
            'desc_en'           => 'nullable',
            'desc_en'           => 'nullable',
            'image'             => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sections')]);
        #store new section
        $section = Section::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة القسم ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'          => 'required|max:255',
            'title_en'          => 'nullable|max:255',
            'short_desc_en'     => 'nullable',
            'short_desc_en'     => 'nullable',
            'desc_en'           => 'nullable',
            'desc_en'           => 'nullable',
            'image'             => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sections')]);
        #update section
        $section = Section::whereId($request->id)->first();
        $section->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل القسم ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get section
        $section = Section::whereId($request->id)->firstOrFail();
        $title_ar = $section->title_ar;

        #send FCM

        #delete section
        $section->delete();

        #add adminReport
        admin_report('حذف القسم ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get sections
        if ($type == 'all') $sections = Section::get();
        else {
            $ids = $request->section_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $section_ids = explode(',', $second_ids);
            $sections = Section::whereIn('id', $section_ids)->get();
        }

        foreach ($sections as $section) {
            #send FCM

            #delete section
            $section->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من قسم');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #send notify
    public function send_notify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        if ($request->type == 'all') $users = User::where('user_type', 'market')->get();
        //else $users = User::whereSectionId($request->id)->get();
        else {
            $users = User::whereHas('sections', function ($q) use ($request){
                return $q->where('section_id', $request->section_id);
            })->get();
        }

        foreach ($users as $user) {
            #notify
            $message = $request->message;
            send_notify($user->id, $message, $message);
            #sms
            #send code to client's phone
            $full_phone = convert_phone_to_international_format($user->phone, '966');
            sms_zain($full_phone, $message, 'msg');
            #push notify
            foreach ($user->devices as $device) {
                $device_id   = $device->device_id;
                if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type);
            }
        }

        return response()->json(['value' => 1, 'msg' => Translate('تم الإرسال بنجاح')]);
    }

    public function change_section_status(Request $request)
    {
        //check data
        $section = Section::whereId($request->id)->first();
        if (!isset($section)) return 0;
        //update data
        $section->show = $section->show == 1 ? 0 : 1;
        $section->save();

        //add report
        $section->show ? admin_report(' اظهار قسم :  ' . $section->title_ar) : admin_report('ألغاء اظهار قسم :  ' . $section->title_ar);
        $msg = $section->show ? Translate('اظهار') : Translate('اخفاء');
        return $msg;
    }
}
