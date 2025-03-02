<?php

namespace App\Http\Controllers\site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\Cart;
use App\Models\City;
use App\Models\Service_offer;
use App\Models\Service_image;
use App\Models\Service;

class serviceController extends Controller
{
    #index
    public function index($section_id)
    {
        $data = Service::whereSectionId($section_id)->get();
        return view('site.services.index', compact('data' , 'section_id'));
    }

    public function change_service_status(Request $request)
{
    //check data
    $service = Service::whereId($request->id)->first();
    if (!isset($service)) return 0;
    //update data
    $service->show = $service->show == 1 ? 0 : 1;
    $service->save();

    //add report
    $msg = $service->show ? Translate('متاح') : Translate('غير متاح');
    return $msg;
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
            'image'             => 'nullable|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new service
        $request->request->add(['user_id' => Auth::id(),'main_section_id' => Auth::user()->section_id]);
        $service = Service::create($request->except(['_token', 'photos']));

        #store image
        if($request->has('photos')){
            $photos = $request->photos;
            foreach ($photos as $key => $photo) {
                $add = new Service_image;
                $add->service_id = $service->id;
                $add->image      = upload_image($photo, 'public/images/services');
                $add->save();
            }
        }

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #edit
    public function edit($id)
    {
        $data = [
            'data'  => Service::whereId($id)->firstOrFail(),
        ];
        return view('site.services.edit', $data);
    }

    public function rmvImage(Request $request)
    {
        $data = Service_image::find($request->id);
        if (!isset($data)) return 'err';

        $count = Service_image::where('service_id', $data->service_id)->count();
        if ($count <= 1) return 'err';

        $data->delete();
        return 'success';
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

        #update service
        $request->request->add(['user_id' => Auth::id(),'main_section_id' => Auth::user()->section_id]);
        $service = Service::whereId($request->id)->first();
        $service->update($request->except(['_token', 'photos', 'amounts', 'prices']));

        #store image
        if($request->has('photos')){
            $photos = $request->photos;
            foreach ($photos as $key => $photo) {
                $add = new Service_image;
                $add->service_id = $service->id;
                $add->image      = upload_image($photo, 'public/images/services');
                $add->save();
            }
        }

        #offers
        Service_offer::whereServiceId($service->id)->delete();
        $amounts  = $request->amounts;
        $prices  = $request->prices;
        foreach($amounts as $key=>$item){
            if(!empty($amounts[$key]) && !empty($prices[$key])){
                Service_offer::create([
                    'amount'       => $amounts[$key],
                    'price'        => $prices[$key],
                    'service_id'   => $service->id
                ]);
            }
        }

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get service
        $service = Service::whereId($request->id)->firstOrFail();
        $title_ar = $service->title_ar;

        #send FCM

        #delete service
        $service->delete();

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get services
        if ($type == 'all') $services = Service::get();
        else {
            $ids = $request->service_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $service_ids = explode(',', $second_ids);
            $services = Service::whereIn('id', $service_ids)->get();
        }

        foreach ($services as $service) {
            #send FCM

            #delete service
            $service->delete();
        }

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
