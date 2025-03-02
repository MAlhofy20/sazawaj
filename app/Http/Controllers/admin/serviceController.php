<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Sub_section;
use Validator;
use App\Models\Service;
use App\Models\Service_image;
use App\Models\Service_option;
use App\Models\Service_side;
use Illuminate\Http\Request;

class serviceController extends Controller
{
    #index
    public function index($sub_section_id)
    {
        /*foreach (Service::get() as $service) {
            $service->update(['price_with_value' => (float)  $service->price + ((float)  $service->price * 15 / 100)]);
            foreach ($service->sizes as $size) {
                $size->update(['price_with_value' => (float)  $size->price + ((float)  $size->price * 15 / 100)]);
            }
            foreach ($service->options as $option) {
                $option->update(['price_with_value' => (float)  $option->price + ((float)  $option->price * 15 / 100)]);
            }
        }*/
        $sub_section = Sub_section::whereId($sub_section_id)->firstOrFail();
        $section_id  = $sub_section->section_id;
        $data        = Service::where('sub_section_id', $sub_section_id)->paginate(200);
        return view('dashboard.services.index', compact('data', 'sub_section_id', 'section_id'));
    }

    #add
    public function add($sub_section_id)
    {
        $sub_section = Sub_section::whereId($sub_section_id)->firstOrFail();
        $section_id  = $sub_section->section_id;
        return view('dashboard.services.add', compact('sub_section_id', 'section_id'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id'        => 'required|exists:sections,id',
            //'sub_section_part_id'    => 'required|exists:sub_section_parts,id',
            'title_ar'          => 'nullable',
            'title_en'          => 'nullable|max:255',
            'short_desc_ar'     => 'nullable',
            'short_desc_en'     => 'nullable',
            'desc_ar'           => 'nullable',
            'desc_en'           => 'nullable',
            'price'             => 'nullable',
            'count'             => 'nullable',
            'photo'             => 'nullable|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #files
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sections')]);
        #store new service
        //price_with_value – (price_with_value / (1 + value_added) x value_added)
        $value_added = $request->value_added / 100;
        $request->request->add([
            'price' => round($request->price_with_value - ($request->price_with_value / (1 + $value_added) * $value_added), 2),
        ]);

        /*$sub_section = Sub_section::whereId($request->sub_section_id)->first();
        $section_id  = isset($sub_section) ? $sub_section->section_id : null;
        $request->request->add(['section_id' => $section_id, 'main_section_id' => $section_id]);*/

        $service = Service::create($request->except([
            '_token', 'photos',
            'size_titles_ar', 'size_titles_en', 'size_prices',
            'option_titles_ar', 'option_titles_en', 'option_prices',
            'side_titles_ar', 'side_titles_en', 'side_prices'
        ]));

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

        if($request->has('size_titles_ar')){
            $size_titles_ar = $request->size_titles_ar;
            $size_titles_en = $request->size_titles_en;
            $size_prices    = $request->size_prices;
            foreach($size_titles_ar as $key=>$item){
                if(!empty($size_titles_ar[$key]) && !is_null($size_prices[$key])){
                    Service_option::create([
                        'title_ar'   => $size_titles_ar[$key],
                        'title_en'   => !empty($size_titles_en[$key]) ? $size_titles_en[$key] : $size_titles_ar[$key],
                        'price_with_value' => $size_prices[$key],
                        'price'      => $size_prices[$key] - ($size_prices[$key] / (1 + $value_added) * $value_added),
                        'type'       => 'size',
                        'service_id' => $service->id
                    ]);
                }
            }
        }

        if($request->has('option_titles_ar')){
            $option_titles_ar = $request->option_titles_ar;
            $option_titles_en = $request->option_titles_en;
            $option_prices    = $request->option_prices;
            foreach($option_titles_ar as $key=>$item){
                if(!empty($option_titles_ar[$key]) && !is_null($option_prices[$key])){
                    Service_option::create([
                        'title_ar'   => $option_titles_ar[$key],
                        'title_en'   => !empty($option_titles_en[$key]) ? $option_titles_en[$key] : $option_titles_ar[$key],
                        'price_with_value' => $option_prices[$key],
                        'price'      => $option_prices[$key] - ($option_prices[$key] / (1 + $value_added) * $value_added),
                        'type'       => 'option',
                        'service_id' => $service->id
                    ]);
                }
            }
        }

        if ($request->has('side_titles_ar')) {
            $side_titles_ar = $request->side_titles_ar;
            $side_titles_en = $request->side_titles_en;
            $side_prices    = $request->side_prices;
            foreach ($side_titles_ar as $key => $item) {
                if (!empty($side_titles_ar[$key]) && !is_null($side_prices[$key])) {
                    Service_option::create([
                        'title_ar'   => $side_titles_ar[$key],
                        'title_en'   => !empty($side_titles_en[$key]) ? $side_titles_en[$key] : $side_titles_ar[$key],
                        'price_with_value' => $side_prices[$key],
                        'price'      => $side_prices[$key] - ($side_prices[$key] / (1 + $value_added) * $value_added),
                        'type'       => 'side',
                        'service_id' => $service->id
                    ]);
                }
            }
        }

        #add adminReport
        admin_report('أضافة المنتج : ' . $service->title_ar);

        #success response
        session()->flash('success', Translate('تم بنجاح'));
        return redirect()->route('services' , $service->sub_section_id);
    }


    #edit
    public function edit($id)
    {
        $data = Service::whereId($id)->firstOrFail();
        return view('dashboard.services.edit', compact('data'));
    }

    public function rmvImage(Request $request)
    {
        $data = Service_image::whereId($request->id)->first();
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
            'title_ar'          => 'nullable',
            'title_en'          => 'nullable|max:255',
            'short_desc_ar'     => 'nullable',
            'short_desc_en'     => 'nullable',
            'desc_ar'           => 'nullable',
            'desc_en'           => 'nullable',
            'price'             => 'nullable',
            'count'             => 'nullable',
            'photo'             => 'nullable',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #files
        if ($request->hasFile('photo'))  $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/sections')]);
        #update service
        //price_with_value – (price_with_value / (1 + value_added) x value_added)
        $value_added = $request->value_added / 100;
        $request->request->add([
            'price' => round($request->price_with_value - ($request->price_with_value / (1 + $value_added) * $value_added), 2),
        ]);

        $sub_section = Sub_section::whereId($request->sub_section_id)->first();
        $section_id  = isset($sub_section) ? $sub_section->section_id : null;
        $request->request->add(['section_id' => $section_id, 'main_section_id' => $section_id]);

        $service = Service::whereId($request->id)->first();
        $service->update($request->except([
            '_token', 'photos',
            'size_titles_ar', 'size_titles_en', 'size_prices',
            'option_titles_ar', 'option_titles_en', 'option_prices',
            'side_titles_ar', 'side_titles_en', 'side_prices'
        ]));

        #store image
        if($request->has('photos')){
            //Service_image::whereServiceId($service->id)->delete();
            $photos = $request->photos;
            foreach ($photos as $key => $photo) {
                $add = new Service_image;
                $add->service_id = $service->id;
                $add->image      = upload_image($photo, 'public/images/services');
                $add->save();
            }
        }

        Service_option::where('service_id', $service->id)->delete();
        if($request->has('size_titles_ar')){
            $size_titles_ar = $request->size_titles_ar;
            $size_titles_en = $request->size_titles_en;
            $size_prices    = $request->size_prices;
            foreach($size_titles_ar as $key=>$item){
                if(!empty($size_titles_ar[$key]) && !is_null($size_prices[$key])){
                    Service_option::create([
                        'title_ar'   => $size_titles_ar[$key],
                        'title_en'   => !empty($size_titles_en[$key]) ? $size_titles_en[$key] : $size_titles_ar[$key],
                        'price_with_value' => $size_prices[$key],
                        'price'      => $size_prices[$key] - ($size_prices[$key] / (1 + $value_added) * $value_added),
                        'type'       => 'size',
                        'service_id' => $service->id
                    ]);
                }
            }
        }

        if($request->has('option_titles_ar')){
            $option_titles_ar = $request->option_titles_ar;
            $option_titles_en = $request->option_titles_en;
            $option_prices    = $request->option_prices;
            foreach($option_titles_ar as $key=>$item){
                if(!empty($option_titles_ar[$key]) && !is_null($option_prices[$key])){
                    Service_option::create([
                        'title_ar'   => $option_titles_ar[$key],
                        'title_en'   => !empty($option_titles_en[$key]) ? $option_titles_en[$key] : $option_titles_ar[$key],
                        'price_with_value' => $option_prices[$key],
                        'price'      => $option_prices[$key] - ($option_prices[$key] / (1 + $value_added) * $value_added),
                        'type'       => 'option',
                        'service_id' => $service->id
                    ]);
                }
            }
        }

        if ($request->has('side_titles_ar')) {
            $side_titles_ar = $request->side_titles_ar;
            $side_titles_en = $request->side_titles_en;
            $side_prices    = $request->side_prices;
            foreach ($side_titles_ar as $key => $item) {
                if (!empty($side_titles_ar[$key]) && !is_null($side_prices[$key])) {
                    Service_option::create([
                        'title_ar'   => $side_titles_ar[$key],
                        'title_en'   => !empty($side_titles_en[$key]) ? $side_titles_en[$key] : $side_titles_ar[$key],
                        'price_with_value' => $side_prices[$key],
                        'price'      => $side_prices[$key] - ($side_prices[$key] / (1 + $value_added) * $value_added),
                        'type'       => 'side',
                        'service_id' => $service->id
                    ]);
                }
            }
        }

        #add adminReport
        admin_report('تعديل المنتج : ' . $service->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return redirect()->route('services' , $service->sub_section_id);
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

        #add adminReport
        admin_report('حذف المنتج : ' . $title_ar);

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

        #add adminReport
        admin_report('حذف اكتر من منتج');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    public function change_service_is_fav(Request $request)
    {
        //check data
        $service = Service::whereId($request->id)->first();
        if (!isset($service)) return 0;
        //update data
        $service->is_fav = $service->is_fav == 1 ? 0 : 1;
        $service->save();

        //add report
        $service->is_fav ? admin_report(' اظهار المنتج في افضل العروض :  ' . $service->title_ar) : admin_report('ألغاء اظهار المنتج في افضل العروض :  ' . $service->title_ar);
        $msg = $service->is_fav ? 'اظهار' : 'اخفاء';
        return $msg;
    }

    public function change_service_best(Request $request)
    {
        //check data
        $service = Service::whereId($request->id)->first();
        if (!isset($service)) return 0;
        //update data
        $service->best = $service->best == 1 ? 0 : 1;
        $service->save();

        //add report
        $service->best ? admin_report(' اظهار المنتج في جديدنا :  ' . $service->title_ar) : admin_report('ألغاء اظهار المنتج في جديدنا :  ' . $service->title_ar);
        $msg = $service->best ? 'اظهار' : 'اخفاء';
        return $msg;
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
        $service->show ? admin_report(' اظهار منتج :  ' . $service->title_ar) : admin_report('ألغاء اظهار منتج :  ' . $service->title_ar);
        $msg = $service->show ? 'اظهار' : 'اخفاء';
        return $msg;
    }
}
