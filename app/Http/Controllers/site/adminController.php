<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;

use App\Models\Role;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;

class adminController extends Controller
{
    #index
    public function index()
    {
        $data = get_users_by('admin', 'asc', 0);
        return view('dashboard.admins', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'      => 'nullable|image',
            'first_name' => 'required|max:255',
            'email'      => 'required|max:255|email|unique:users,email',
            'phone'      => 'required|min:9|max:13|unique:users,phone',
            'role_id'    => 'required|max:255',
            'password'   => 'required|min:6|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) $avatar = upload_image($request->file('photo'), 'public/images/users');
        else $avatar = '/public/user.png';
        #store new client
        $request->request->add(['active' => 1, 'blocked' => 0, 'avatar' => $avatar, 'user_type' => 'admin']);
        $admin = User::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة المدير ' . $admin->name);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'      => 'nullable|image',
            'first_name' => 'required|max:255',
            'phone'      => 'required|min:9|max:13|unique:users,phone,' . $request->id,
            'email'      => 'required|max:255|email|unique:users,email,' . $request->id,
            // 'password'   => 'nullable|min:6|max:255',
            'role_id'    => 'required|max:255',

        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/users')]);
        #update client
        $admin = User::whereId($request->id)->first();
        $admin->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل المدير ' . $admin->name);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get admin
        $admin = User::whereId($request->id)->firstOrFail();
        $name = $admin->name;

        #send FCM

        #delete admin
        $admin->delete();

        #add adminReport
        admin_report('حذف المدير ' . $name);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get admins
        if ($type == 'all') $admins = User::where('user_type', 'admin')->get();
        else {
            $ids = $request->admin_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $admin_ids    = explode(',', $second_ids);
            $admins       = User::whereIn('id', $admin_ids)->get();
        }

        foreach ($admins as $admin) {
            #send FCM

            #delete admin
            $admin->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من مدير');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
