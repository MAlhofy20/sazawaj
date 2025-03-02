<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Bank_account;
use Illuminate\Http\Request;

class bank_accountController extends Controller
{
    #index
    public function index()
    {
        $data = Bank_account::orderBy('title_ar', 'asc')->get();
        return view('dashboard.bank_accounts', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'       => 'required|max:255',
            /*'title_en'       => 'nullable|max:255',
            'photo'          => 'required|image',
            'account_name'   => 'required',
            'account_number' => 'required',
            'iban_number'    => 'required',*/
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/bank_accounts')]);
        #store new bank account
        $bank_account = Bank_account::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة بنك ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'       => 'required|max:255',
            /*'title_en'       => 'nullable|max:255',
            'photo'          => 'nullable|image',
            'account_name'   => 'required',
            'account_number' => 'required',
            'iban_number'    => 'required',*/
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/bank_accounts')]);
        #update client
        $bank_account = Bank_account::whereId($request->id)->first();
        $bank_account->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل بنك ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get bank_account
        $bank_account = Bank_account::whereId($request->id)->firstOrFail();
        $title_ar = $bank_account->title_ar;

        #send FCM

        #delete bank_account
        $bank_account->delete();

        #add adminReport
        admin_report('حذف بنك ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get bank_accounts
        if ($type == 'all') $bank_accounts = Bank_account::get();
        else {
            $ids = $request->bank_account_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $bank_account_ids    = explode(',', $second_ids);
            $bank_accounts = Bank_account::whereIn('id', $bank_account_ids)->get();
        }

        foreach ($bank_accounts as $bank_account) {
            #delete bank_account
            $bank_account->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من بنك');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
