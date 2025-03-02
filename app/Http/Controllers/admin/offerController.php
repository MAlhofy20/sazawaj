<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Offer;
use Illuminate\Http\Request;

class offerController extends Controller
{
    #index
    public function index()
    {
        $data = Offer::orderBy('id', 'asc')->get();
        return view('dashboard.offers', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new bank account
        Offer::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة عرض ');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update client
        $offer = Offer::whereId($request->id)->first();
        $offer->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل عرض ');

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get offer
        $offer = Offer::whereId($request->id)->firstOrFail();
        $title = $offer->title;

        #send FCM

        #delete offer
        $offer->delete();

        #add adminReport
        admin_report('حذف عرض ');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get offers
        if ($type == 'all') $offers = Offer::get();
        else {
            $ids = $request->offer_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $offer_ids    = explode(',', $second_ids);
            $offers = Offer::whereIn('id', $offer_ids)->get();
        }

        foreach ($offers as $offer) {
            #delete offer
            $offer->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من عرض');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
