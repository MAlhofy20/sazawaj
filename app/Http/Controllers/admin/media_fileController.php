<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Media_file;
use App\Models\Media_image;
use Illuminate\Http\Request;

class media_fileController extends Controller
{
    #index
    public function index($type)
    {
        $data = Media_file::whereType($type)->get();
        return view('dashboard.media_file.index', compact('data', 'type'));
    }

    #add
    public function add($type)
    {
        return view('dashboard.media_file.add', compact('type'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'title_ar'      => 'required|max:255',
            // 'title_en'      => 'nullable|max:255',
            // 'desc_ar'       => 'required',
            // 'desc_en'       => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'images/sliders')]);
        if ($request->hasFile('video_photo')) $request->request->add(['video' => upload_image($request->file('video_photo'), 'images/sliders')]);
        if ($request->hasFile('pdf_photo')) $request->request->add(['pdf' => upload_image($request->file('pdf_photo'), 'images/sliders')]);
        #store new media_file
        $media_file = Media_file::create($request->except(['_token', 'photo', 'photos', 'video_photo', 'pdf_photo']));

        #photos
        if ($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                if (!empty($photo)) Media_image::create(['media_id' => $media_file->id, 'image' => upload_image($photo, 'images/sliders')]);
            }
        }

        #add adminReport
        admin_report('أضافة عنصر الى المركز الاعلامي ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        // return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
        return redirect('media_files/' . $request->type);
    }

    public function rmvImage(Request $request)
    {
        $data = Media_image::find($request->id);
        if (!isset($data)) return 'err';

        /*$count = Media_image::where('service_id', $data->service_id)->count();
        if ($count <= 1) return 'err';*/

        $data->delete();
        return 'success';
    }

    #edit
    public function edit($id)
    {
        $data = Media_file::whereId($id)->firstOrFail();
        return view('dashboard.media_file.edit', compact('data'));
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'title_ar'      => 'required|max:255',
            //'title_en'      => 'required|max:255',
            //'desc_ar'       => 'required',
            //'desc_en'       => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'images/sliders')]);
        if ($request->hasFile('video_photo')) $request->request->add(['video' => upload_image($request->file('video_photo'), 'images/sliders')]);
        if ($request->hasFile('pdf_photo')) $request->request->add(['pdf' => upload_image($request->file('pdf_photo'), 'images/sliders')]);
        #update media_file
        $media_file = Media_file::whereId($request->id)->first();
        $media_file->update($request->except(['_token', 'photo', 'photos', 'video_photo', 'pdf_photo']));

        #photos
        if ($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                if (!empty($photo)) Media_image::create(['media_id' => $media_file->id, 'image' => upload_image($photo, 'images/sliders')]);
            }
        }

        #add adminReport
        admin_report('تعديل عنصر من المركز الاعلامي ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        // return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
        return redirect('media_files/' . $media_file->type);
    }

    #delete one
    public function delete(Request $request)
    {
        #get media_file
        $media_file = Media_file::whereId($request->id)->firstOrFail();
        $title_ar = $media_file->title_ar;

        #send FCM

        #delete media_file
        $media_file->delete();

        #add adminReport
        admin_report('حذف العنصر من المركز الاعلامي ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get media_files
        if ($type == 'all') $media_files = Media_file::get();
        else {
            $ids = $request->media_file_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $media_file_ids    = explode(',', $second_ids);
            $media_files = Media_file::whereIn('id', $media_file_ids)->get();
        }

        foreach ($media_files as $media_file) {
            #send FCM

            #delete media_file
            $media_file->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من عنصر من المركز الاعلامي');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
