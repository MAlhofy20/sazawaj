<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Not_now_offer;
use App\Models\Order;
use App\Models\User_image;
use App\Models\User_transction;
use App\Models\Neighborhood;
use App\Models\Role;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;

class marketController extends Controller
{
    #index
    public function index()
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        /** get cart Data **/
        $query = User::query();
        $query->where('manager_id', auth()->id());
        $query->where('user_type', 'market');
        if (isset($queries['name']) && !empty($queries['name'])) {
            $query->where(function($q) use ($queries){
                $q->where('first_name' , 'like' , '%' . $queries['name'] . '%')->orWhere('full_name' , 'like' , '%' . $queries['name'] . '%');
            });
        }
        if (isset($queries['phone']) && !empty($queries['phone'])) {
            $query->where('phone' , $queries['phone']);
        }
        if (isset($queries['email']) && !empty($queries['email'])) {
            $query->where('email' , $queries['email']);
        }
        if (isset($queries['account']) && !empty($queries['account'])) {
            $query->where(function($q){
                return $q->where('total_user_debt' , '>' , 0)->orWhere('total_admin_debt' , '>' , 0);
            });
        }
        $query->orderBy('created_at', 'asc');
        $data = $query->paginate(10);

        //$data = get_users_by('market', 'asc', 10);
        //$data = User::where('user_type', 'market')->orderBy('id', 'desc')->paginate(20);
        return view('site.markets', compact('data' , 'queries'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar'     => 'nullable|image',
            'full_name_ar' => 'required|max:255',
            'full_name_en' => 'required|max:255',
            // 'email'      => 'required|max:255|email|unique:users,email',
            // 'phone'      => 'required|min:9|max:13|unique:users,phone',
            // 'price'      => 'required',
            // 'address'    => 'nullable|max:255',
            // 'password'   => 'required|min:6|max:255',
        ], [
            'full_name_ar.required' => 'اسم الملعب بالعربية مطلوب',
            'full_name_en.required' => 'اسم الملعب بالانجليزية مطلوب'
        ]);

        #error response
        if ($validator->fails()) return back();
            //return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) $avatar = upload_image($request->file('photo'), 'public/images/users');
        else $avatar = '/public/user.png';
        #pay_by
        $request->request->add(['cash' => $request->has('by_cash') ? 1 : 0, 'transfer' => $request->has('by_transfer') ? 1 : 0, 'online' => $request->has('by_online') ? 1 : 0, 'not_now' => $request->has('by_not_now') ? 1 : 0]);
        #city
        $city = City::whereId($request->city_id)->first();
        $request->request->add(['country_id' => isset($city) ? $city->country_id : null]);
        #store new client
        $request->request->add([
            'manager_id' => auth()->id(),
            'first_name' => $request->full_name_ar,
            'active' => 1,
            'blocked' =>0,
            'compelete' => 1,
            'avatar' =>$avatar,
            // 'password' => '123456',
            'user_type' => 'market',
            'role_id' => Role::first()->id
        ]);
        $user = User::create($request->except(['_token', 'photo','id_photo','pac-input','by_cash','by_transfer','by_online','by_not_now']));
        
        #add adminReport
        admin_report('أضافة الملعب ' . $user->name);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return back();
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    public function rmvImage(Request $request)
    {
        $data = User_image::whereId($request->id)->first();
        if (!isset($data)) return 'err';

        $count = User_image::where('user_id', $data->user_id)->count();
        if ($count <= 1) return 'err';

        $data->delete();
        return 'success';
    }


    #edit
    public function edit($id)
    {
        $data = User::whereId($id)->firstOrFail();
        return view('site.markets_edit', compact('data'));
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar'     => 'nullable|image',
            'full_name_ar' => 'required|max:255',
            'full_name_en' => 'required|max:255',
            // 'phone'      => 'required|min:9|max:13|unique:users,phone,' . $request->id,
            // 'email'      => 'required|max:255|email|unique:users,email,' . $request->id,
            // 'password'   => 'nullable|min:6|max:255',
            'address'    => 'nullable|max:255',

        ], [
            'full_name_ar.required' => 'اسم الملعب بالعربية مطلوب',
            'full_name_en.required' => 'اسم الملعب بالانجليزية مطلوب'
        ]);

        #error response
        if ($validator->fails()) return back();
            // return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/users')]);
        if ($request->hasFile('id_photo')) $request->request->add(['id_image' => upload_image($request->file('id_photo'), 'public/images/users')]);
        #pay_by
        $request->request->add(['cash' => $request->has('by_cash') ? 1 : 0,'transfer' => $request->has('by_transfer') ? 1 : 0, 'online' => $request->has('by_online') ? 1 : 0, 'not_now' => $request->has('by_not_now') ? 1 : 0]);
        #city
        $city = City::whereId($request->city_id)->first();
        $request->request->add(['first_name' => $request->full_name_ar, 'country_id' => isset($city) ? $city->country_id : null]);
        #update client
        $user = User::whereId($request->id)->first();

        if(empty($request->password)) $user->update($request->except(['_token', 'photo','id_photo','edit_pac-input','password','by_cash','by_transfer','by_online','by_not_now', 'photos']));
        else $user->update($request->except(['_token', 'photo','id_photo','edit_pac-input','by_cash','by_transfer','by_online','by_not_now', 'photos']));

        #store image
        if($request->has('photos')){
            $photos = $request->file('photos');
            foreach ($photos as $key => $photo) {
                $add = new User_image;
                $add->user_id = $user->id;
                $add->image   = upload_image($photo, 'public/images/services');
                $add->save();
            }
        }

        #add adminReport
        admin_report('تعديل الملعب ' . $user->name);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return back();
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get market
        $user = User::whereId($request->id)->firstOrFail();
        $name = $user->name;

        #send FCM

        #delete market
        $user->delete();

        #add adminReport
        admin_report('حذف الملعب ' . $name);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get markets
        if ($type == 'all') $users = User::where('user_type', 'market')->get();
        else {
            $ids = $request->user_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $user_ids    = explode(',', $second_ids);
            $users = User::whereIn('id', $user_ids)->get();
        }

        foreach ($users as $user) {
            #send FCM

            #delete market
            $user->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من مندوب');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #change market status (active - blocked)
    public function confirm_market(Request $request)
    {
        //check data
        $user = User::whereId($request->id)->first();
        if (!isset($user)) return 'err';
        //update data
        $user->confirm = 1;
        $user->save();

        //add report
        admin_report(' تفعيل الملعب ' . $user->name);
        $msg = Translate('حساب مفعل');
        return $msg;
    }

    #change market status (active - blocked)
    public function change_market_status(Request $request)
    {
        //check data
        $user = User::whereId($request->id)->first();
        if (!isset($user)) return 0;
        //update data
        $user->blocked = $user->blocked == 1 ? 0 : 1;
        $user->save();

        if ($user->blocked) {
            $lang = $user->lang ?? 'ar';
            $body = [
                'msg_ar'  => 'تم حظر حسابك الان من قبل الادارة',
                'msg_en'  => 'your account is blocked now by admin',
            ];
            $data   = [];
            $data['title']      = settings('site_name');
            $data['body']       = $body['msg_' . $lang];
            $data['status']     = 'user_blocked';
            // foreach ($user->Devices as $device) {
            //     send_fcm($device->device_id, $data, $device->device_type);
            // }

            // Device::where('user_id', $user->id)->delete();
        }
        //add report
        $user->blocked ? admin_report(' حظر الملعب ' . $user->name) : admin_report('ألغاء حظر الملعب ' . $user->name);
        $msg = $user->blocked ? Translate('حظر') : Translate('مفعل');
        return $msg;
    }

    #change market fav
    public function change_market_fav(Request $request)
    {
        //check data
        $user = User::whereId($request->id)->first();
        if (!isset($user)) return 0;
        //update data
        $user->is_fav = $user->is_fav == 1 ? 0 : 1;
        $user->save();

        //add report
        !$user->is_fav ? admin_report(' الغاء ظهور الملعب ' . $user->name) : admin_report('بظهور الملعب ' . $user->name);
        $msg = !$user->is_fav ? 'اخفاء' : 'اظهار';
        return $msg;
    }

    #send notify
    public function send_notify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        if ($request->type == 'all') $users = User::where('user_type', 'market')->get();
        else $users = User::whereId($request->id)->get();

        foreach ($users as $user) {
            $message = $request->message;
            send_notify($user->id, $message, $message);
            foreach ($user->devices as $device) {
                $device_id   = $device->device_id;
                if (!is_null($device_id)) send_one_signal($message, $device_id);
            }
        }

        return response()->json(['value' => 1, 'msg' => Translate('تم الإرسال بنجاح')]);
    }
}
