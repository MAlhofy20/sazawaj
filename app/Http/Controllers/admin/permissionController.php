<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class permissionController extends Controller
{
    #index
    public function index()
    {
        $data = Role::get();
        return view('dashboard.permissions.index', compact('data'));
    }

    #add
    public function add()
    {
        $routes = collect(Route::getRoutes());
        return view('dashboard.permissions.add',compact('routes'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|max:255|unique:roles',
            'permissions'    => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new role
        $role = new Role();
        $role->name         = $request->name;
        $role->display_name = $request->name; // optional
        $role->description  = $request->name; // optional
        $role->save();

        #role's permissions
        foreach ($request->permissions as $permission) {
            ##store role's permissions
            $createPost = new Permission();
            $createPost->name         = $permission;
            $createPost->display_name = $permission; // optional
            $createPost->description  = $permission; // optional
            $createPost->role_id      = $role->id;
            $createPost->save();
        }

        #add adminReport
        admin_report('أضافة الصلاحية ' . $request->name);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #edit
    public function edit($role_id)
    {
        $routes = Route::getRoutes();
        $role   = Role::whereId($role_id)->firstOrFail();
        $permissions = Permission::whereRoleId($role_id)->pluck('name')->toArray();
        return view('dashboard.permissions.edit', compact('role', 'routes', 'permissions'));
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|max:255|unique:roles,name,' . $request->id,
            'permissions'   => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update role
        $role = Role::whereId($request->id)->firstOrFail();
        $role->name         = $request->name;
        $role->display_name = $request->name; // optional
        $role->description  = $request->name; // optional
        $role->save();

        #delete role's permissions
        Permission::whereRoleId($request->id)->delete();

        #role's permissions
        foreach ($request->permissions as $permission) {
            ##update role's permissions
            $createPost = new Permission();
            $createPost->name         = $permission;
            $createPost->display_name = $permission; // optional
            $createPost->description  = $permission; // optional
            $createPost->role_id      = $role->id;
            $createPost->save();
        }

        #add adminReport
        admin_report('تعديل الصلاحية ' . $request->name);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get role
        $role = Role::whereId($request->id)->firstOrFail();
        $name = $role->name;

        #delete role
        // Force Delete
        $role->delete();

        #add adminReport
        admin_report('حذف الصلاحية ' . $name);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
