<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_report;
use App\Models\Contact;
use Illuminate\Http\Request;

class contactController extends Controller
{
    #index
    public function index($type)
    {
        $data = Contact::whereType($type)->orderBy('id', 'desc')->get();
        return view('dashboard.contacts', compact('data', 'type'));
    }

    #delete one
    public function delete(Request $request)
    {
        #get contact
        $contact = Contact::whereId($request->id)->delete();

        #add adminReport
        admin_report('حذف رسالة من تواصل معنا ');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get contacts
        if ($type == 'all') $contacts = Contact::get();
        else {
            $ids = $request->contact_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $contact_ids = explode(',', $second_ids);
            $contacts = Contact::whereIn('id', $contact_ids)->get();
        }

        foreach ($contacts as $contact) {
            #delete contact
            $contact->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من رسالة من تواصل معنا');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
