<?php

namespace App\Http\Controllers\admin;

use App\Models\Contact;
use App\Models\Admin_report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAdminMessageMailable;

class contactController extends Controller
{
    #index
    public function index($type)
    {
        $data = Contact::whereType($type)->orderBy('id', 'desc')->get();
        return view('dashboard.contacts', compact('data', 'type'));
    }

    #replay
    public function replay(Request $request, $id)
    {
        $contact = Contact::whereId($id)->first();
        if($contact){
            $data = [
                'title' => 'لديك رد من الادارة على رسالتك',
                'body' => $request->message,
            ];
            Mail::to($contact->email)->send(new NewAdminMessageMailable($data));
        }
        #add adminReport
        admin_report('ارسال رد على رسالة من تواصل معنا');

        #success response
        return back()->with('success', Translate('تم الارسال'));
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
