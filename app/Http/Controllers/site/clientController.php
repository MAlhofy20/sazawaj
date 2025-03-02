<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Client;
use Illuminate\Http\Request;

class clientController extends Controller
{
    #index
    public function index()
    {
        $data = Client::get();
        return view('dashboard.clients', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'          => 'nullable|max:255',
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
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/clients')]);
        #store new client
        $client = Client::create($request->except(['_token', 'photo']));

        #add siteReport
        site_report('أضافة شريك ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'          => 'nullable|max:255',
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
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/clients')]);
        #update client
        $client = Client::whereId($request->id)->first();
        $client->update($request->except(['_token', 'photo']));

        #add siteReport
        site_report('تعديل شريك ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get client
        $client = Client::whereId($request->id)->firstOrFail();
        $title_ar = $client->title_ar;

        #send FCM

        #delete client
        $client->delete();

        #add siteReport
        site_report('حذف شريك ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get clients
        if ($type == 'all') $clients = Client::get();
        else {
            $ids = $request->client_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $client_ids = explode(',', $second_ids);
            $clients = Client::whereIn('id', $client_ids)->get();
        }

        foreach ($clients as $client) {
            #send FCM

            #delete client
            $client->delete();
        }

        #add siteReport
        site_report('حذف اكتر من سؤال');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
