<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bank_transfer;
use Illuminate\Http\Request;

class bank_transferController extends Controller
{
    #index
    public function index()
    {
        $data = Bank_transfer::get();
        return view('dashboard.bank_transfers', compact('data'));
    }

    #delete one
    public function delete(Request $request)
    {
        #get bank_transfer
        $bank_transfer = Bank_transfer::whereId($request->id)->delete();

        #add adminReport
        admin_report('حذف تحويل بنكي ');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get bank_transfers
        if ($type == 'all') $bank_transfers = Bank_transfer::get();
        else {
            $ids = $request->bank_transfer_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $bank_transfer_ids = explode(',', $second_ids);
            $bank_transfers = Bank_transfer::whereIn('id', $bank_transfer_ids)->get();
        }

        foreach ($bank_transfers as $bank_transfer) {
            #delete bank_transfer
            $bank_transfer->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من تحويل بنكي');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
