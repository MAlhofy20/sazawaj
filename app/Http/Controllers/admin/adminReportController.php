<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_report;
use Illuminate\Http\Request;

class adminReportController extends Controller
{
    #index
    public function index()
    {
        $data = Admin_report::orderBy('id', 'desc')->get();
        return view('dashboard.admin_reports', compact('data'));
    }

    #delete one
    public function delete(Request $request)
    {
        #get admin_report
        $admin_report = Admin_report::whereId($request->id)->delete();

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get admin_reports
        if ($type == 'all') $admin_reports = Admin_report::get();
        else {
            $ids = $request->admin_report_ids;
            $first_ids      = ltrim($ids, ',');
            $second_ids     = rtrim($first_ids, ',');
            $admin_report_ids = explode(',', $second_ids);
            $admin_reports  = Admin_report::whereIn('id', $admin_report_ids)->get();
        }

        foreach ($admin_reports as $admin_report) {
            #delete admin_report
            $admin_report->delete();
        }

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
