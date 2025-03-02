<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\User_note;
use Illuminate\Http\Request;

class user_noteController extends Controller
{
    #index
    public function index($user_id)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        /** get cart Data **/
        $filter = '';
        $query = User_note::query();
        $query->where('user_id', $user_id);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('created_at', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date'])) $query->whereDate('created_at', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $data = $query->get();

        //$data = User_note::where('user_id', $user_id)->get();
        return view('dashboard.user_notes', compact('data', 'user_id', 'queries'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/user_notes')]);
        #store new user_note
        $user_note = User_note::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة ملاحظة الفرع');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/user_notes')]);
        #update user_note
        $user_note = User_note::whereId($request->id)->first();
        $user_note->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل ملاحظة الفرع');

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get user_note
        $user_note = User_note::whereId($request->id)->firstOrFail();

        #send FCM

        #delete user_note
        $user_note->delete();

        #add adminReport
        admin_report('حذف ملاحظة الفرع');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get user_notes
        if ($type == 'all') $user_notes = User_note::get();
        else {
            $ids = $request->user_note_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $user_note_ids = explode(',', $second_ids);
            $user_notes = User_note::whereIn('id', $user_note_ids)->get();
        }

        foreach ($user_notes as $user_note) {
            #send FCM

            #delete user_note
            $user_note->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من ملاحظة لفرع');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}