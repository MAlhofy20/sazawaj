<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Sub_section_part;
use App\Models\Sub_section;
use Illuminate\Http\Request;

class sub_section_partController extends Controller
{
    #index
    public function index($sub_section_id)
    {
        $sub_section = Sub_section::whereId($sub_section_id)->firstOrFail();
        $seen = !is_null($sub_section->section) ? $sub_section->section->type == 'book' : false;
        $data = Sub_section_part::where('sub_section_id' , $sub_section_id)->get();
        return view('dashboard.sub_section_parts', compact('data','sub_section_id','seen'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'          => 'required|max:255',
            'title_en'          => 'nullable|max:255',
            'image'             => 'nullable|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sections')]);
        #store new sub_section_part
        $sub_section_part = Sub_section_part::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة الفصل ' . $request->title_ar);

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
            'image'             => 'nullable|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sections')]);
        #update sub_section_part
        $sub_section_part = Sub_section_part::whereId($request->id)->first();
        $sub_section_part->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل الفصل ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get sub_section_part
        $sub_section_part = Sub_section_part::whereId($request->id)->firstOrFail();
        $title_ar = $sub_section_part->title_ar;

        #send FCM

        #delete sub_section_part
        $sub_section_part->delete();

        #add adminReport
        admin_report('حذف الفصل ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get sub_section_parts
        if ($type == 'all') $sub_section_parts = Sub_section_part::get();
        else {
            $ids = $request->sub_section_part_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $sub_section_part_ids = explode(',', $second_ids);
            $sub_section_parts = Sub_section_part::whereIn('id', $sub_section_part_ids)->get();
        }

        foreach ($sub_section_parts as $sub_section_part) {
            #send FCM

            #delete sub_section_part
            $sub_section_part->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من فصل');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
