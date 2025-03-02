<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Promo_code;
use Illuminate\Http\Request;

class promo_codeController extends Controller
{
    #index
    public function index()
    {
        $data = Promo_code::orderBy('code', 'asc')->get();
        return view('dashboard.promo_codes', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'     => 'required|max:255|unique:promo_codes,code',
            'discount' => 'required',
            'type'     => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new promo_code
        Promo_code::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة الكود ' . $request->code);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'     => 'required|max:255|unique:promo_codes,code,' . $request->id,
            'discount' => 'required',
            'type'     => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update promo_code
        if ($request->type != 'one_use') $request->request->add(['status' => null]);
        Promo_code::whereId($request->id)->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل الكود ' . $request->code);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get promo_code
        $promo_code = Promo_code::whereId($request->id)->firstOrFail();
        $code = $promo_code->code;

        #send FCM

        #delete promo_code
        $promo_code->delete();

        #add adminReport
        admin_report('حذف الكود ' . $code);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get promo_codes
        if ($type == 'all') $promo_codes = Promo_code::get();
        else {
            $ids = $request->promo_code_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $promo_code_ids    = explode(',', $second_ids);
            $promo_codes = Promo_code::whereIn('id', $promo_code_ids)->get();
        }

        foreach ($promo_codes as $promo_code) {
            #send FCM

            #delete promo_code
            $promo_code->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من كود');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
