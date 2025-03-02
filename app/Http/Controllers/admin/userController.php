<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Role;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Device;
use App\Models\User_transction;
use Illuminate\Http\Request;
use App\Mail\ActiveCode;use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfilePictureAcceptedNotification;
use App\Notifications\NewAdminMessageNotification;

class userController extends Controller
{
    #index
    public function index()
    {
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        /** get cart Data **/
        $query = User::query();
        $query->where('user_type', 'client');
        if(isset($queries['edit']) && (int) $queries['edit'] > 0) {
            $query->where('edit_seen', '0')->where('avatar_edit', '!=', null);
        }
        if (isset($queries['name']) && !empty($queries['name'])) {
            $query->where(function ($q) use ($queries) {
                $q->where('first_name', 'like', '%' . $queries['name'] . '%')->orWhere('full_name_ar', 'like', '%' . $queries['name'] . '%');
            });
        }
        if (isset($queries['phone']) && !empty($queries['phone'])) {
            $query->where('phone', $queries['phone']);
        }
        if (isset($queries['email']) && !empty($queries['email'])) {
            $query->where('email', $queries['email']);
        }
        if (isset($queries['package_status']) && !empty($queries['package_status'])) {
            if($queries['package_status'] == '1') $query->where('package_end_date', '!=', null)->whereDate('package_end_date', '>=', Carbon::now());
            if($queries['package_status'] == '2') $query->whereDate('package_end_date', '<', Carbon::now())->orWhere('package_end_date', null);
        }
        if (isset($queries['created']) && !empty($queries['created'])) {
            if ($queries['created'] == 'custom' && isset($queries['created_custom_date']) && !empty($queries['created_custom_date'])) {
                $date = Carbon::parse($queries['created_custom_date']);
                $query->whereDate('created_at', '>=', $date);
            } else {
                $days = (int) $queries['created'];
                $date = Carbon::now()->subDays($days);
                $query->whereDate('created_at', '>=', $date);
            }
        }
            if (isset($queries['logout']) && !empty($queries['logout'])) {
                if ($queries['logout'] == 'custom' && isset($queries['logout_custom_date']) && !empty($queries['logout_custom_date'])) {
                    $date = Carbon::parse($queries['logout_custom_date']);
                } else {
                    $days = (int) $queries['logout'];
                    $date = Carbon::now()->subDays($days);
                }

                $query->whereDate('logout_date', '>=', $date);
            }

            $query->orderBy('logout_date', 'asc');


            $query->orderBy('created_at', 'desc');
            $data = $query->paginate(50);

            //$data = get_users_by('client', 'asc', 10);
            return view('dashboard.users', compact('data', 'queries'));
        }

    #orders
    public function orders($id)
    {
        $user = User::whereId($id)->firstOrFail();
        $data = Order::whereUserId($id)->whereStatus('finish')->get();

        return view('dashboard.orders.user_report', compact('data', 'user'));
    }

    #paid
    public function paid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'debt'           => 'required',
        ], [
            'debt.required'  => 'المبلغ المسدد مطلوب',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        $user = User::whereId($request->id)->firstOrFail();
        $debt = (float) convert_to_english($request->debt);

        if ($debt <= 0) return back();

        $user_debt  = $user->total_user_debt;
        $admin_debt = $user->total_admin_debt;

        if ($request->type == 'user') {
            $user->update([
                'total_user_debt'       => $debt > $user_debt ? 0 : $user_debt - $debt,
                'total_admin_debt'      => $debt > $user_debt ? $admin_debt + 0 : $admin_debt + ($user_debt - $debt),
            ]);
        } else {
            $user->update([
                'total_user_debt'       => $debt > $admin_debt ? $user_debt + ($debt - $admin_debt) : $user_debt + 0,
                'total_admin_debt'      => $admin_debt >= $debt ? $admin_debt - $debt : 0,
            ]);
        }

        User_transction::create([
            'user_id' => $user->id,
            'amount'  => $debt
        ]);

        #add adminReport
        admin_report('تسوية حساب العميل :  ' . $user->name);

        #success response
        session()->flash('success', Translate('تم بنجاح'));
        return back();
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'      => 'nullable',
            'first_name' => 'required|max:255',
            'email'      => 'required|max:255|email|unique:users,email',
            //'phone'      => 'required|min:9|max:13|unique:users,phone',
            'phone_code' => 'nullable',
            'password'   => 'required|min:6|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) $avatar = upload_image($request->file('photo'), 'public/images/users');
        else $avatar = '/public/user.png';
        #store new client
        $request->request->add(['active' => 1, 'blocked' => 0, 'avatar' => $avatar, 'user_type' => 'client', 'role_id' => Role::first()->id, 'api_token' => Str::random(80)]);
        $user = User::create($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('أضافة العميل ' . $user->name);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'      => 'nullable',
            'first_name' => 'required|max:255',
            'email'      => 'required|max:255|email|unique:users,email,' . $request->id,
            //'phone'      => 'required|min:9|max:13|unique:users,phone,' . $request->id,
            'phone_code' => 'nullable',
            'password'   => 'nullable|min:6|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/users')]);
        #update client
        $user = User::whereId($request->id)->first();
        if (empty($request->password)) $user->update($request->except(['_token', 'photo', 'password']));
        else $user->update($request->except(['_token', 'photo']));

        #add adminReport
        admin_report('تعديل العميل ' . $user->name);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    public function update_package(Request $request)
    {
        #subscripe package
        if($request->package_id == 'empty') {
            $user    = User::whereId($request->id)->first();
            $user->update([
                'package_id'       => null,
                'package_title'    => null,
                'package_date'     => null,
                'package_end_date' => null,
            ]);
        }
        else{
            $package = Package::whereId($request->package_id)->firstOrFail();
            $amount  = (int) $package->amount;
            $user    = User::whereId($request->id)->first();
            $user->update([
                'package_id'       => $request->package_id,
                'package_title'    => $package->title_ar,
                'package_date'     => Carbon::now(),
                'package_end_date' => Carbon::now()->addMonths($amount),
            ]);
        }

        #add adminReport
        admin_report('تعديل باقة العميل ' . $user->name);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        //return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
        return back();
    }

    #delete one
    public function delete(Request $request)
    {
        #get client
        $user = User::whereId($request->id)->firstOrFail();
        $name = $user->name;

        #send FCM

        #delete client
        $user->delete();

        #add adminReport
        admin_report('حذف العميل ' . $name);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get clients
        if ($type == 'all') $users = User::where('user_type', 'client')->get();
        else {
            $ids = $request->user_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $user_ids    = explode(',', $second_ids);
            $users = User::whereIn('id', $user_ids)->get();
        }

        foreach ($users as $user) {
            #send FCM

            #delete client
            $user->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من عميل');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #checkout_wallet
    public function checkout_wallet(Request $request)
    {
        //check data
        $user = User::whereId($request->id)->first();
        if (!isset($user)) return 0;
        //update data
        $user->wallet = (float) $user->wallet - (float) $request->amount;
        $user->save();

        /*$lang = $user->lang ?? 'ar';
        $message = [
            'ar'  => 'تم تحويل مبلغ ' . (float) $request->amount . '  ريال الى حسابك من قبل الادارة',
            'en'  => 'Transfer amount ' . (float) $request->amount . ' R.S to your account by admin',
        ];
        send_notify($user->id, $message['ar'], $message['en']);
        foreach ($user->devices as $device) {
            $device_id   = $device->device_id;
            if (!is_null($device_id)) send_one_signal($message[$lang], $device_id);
        }*/

        if(isset($user)) {
            $lang = $user->lang == 'en' ? 'en' : 'ar';
            $msg = [
                'title_ar'  => 'تم تحويل مبلغ ' . (float) $request->amount . '  ريال الى حسابك من قبل الادارة',
                'title_en'  => 'Transfer amount ' . (float) $request->amount . ' R.S to your account by admin',
            ];
            $message = $msg['title_' . $lang];
            $data    = ['title' => settings('site_name'), 'body' => $message];
            send_notify($user->id, $msg['title_ar'], $msg['title_en']); //$order->id, 'new');
            foreach (Device::whereUserId($user->id)->get() as $device) {
                $device_id = $device->device_id;
                //if (!is_null($device_id)) send_one_signal($message, $device_id);
                if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
            }
        }

        #success response
        session()->flash('success', Translate('تم بنجاح'));
        return back();
    }

    public function avatar_user_seen(Request $request)
    {
        //check data
        $user = User::whereId($request->id)->first();
        if (!isset($user)) return 0;
        //update data
        $user->avatar      = !empty($user->avatar_edit) && $user->edit_seen == 0 ? $user->avatar_edit : $user->avatar;
        $user->avatar_seen = $user->avatar_seen == 1 && $user->edit_seen == 1 ? 0 : 1;
        $user->edit_seen   = 1;
        $user->avatar_edit = null;
        $user->save();

        // foreach(Device::where('user_id', $user->id)->pluck('device_id') as $token) {
        //     sendFCMNotificationToWeb($token, ['title' => settings('site_name'), 'body' => 'تم الموافقة على عرض صورتك الشخصية'], url('show_client/' . $user->id));
        // }

        // $title = "<html><head><title></title></head><body dir='rtl' style='text-align: right'><p>تم الموافقة على عرض صورتك الشخصية</p></body></html>";
        // send_mail_html($user->email, $title);
        $data = [
            'title' => 'تحديث الملف الشخصي', 
            'body' => 'تم الموافقة على عرض صورتك الشخصية',
            'btn-text' => 'صفحتي الشخصية',
            'url' => url('show_client/' . $user->id),
            'user' => $user,
        ];
        $user->notify(new ProfilePictureAcceptedNotification($data));
        send_notify($user->id, $data['body'], $data['body'],$data['url']);

        //add report
        $user->avatar_seen && $user->edit_seen ? admin_report(' اظهار صورة العميل ' . $user->name) : admin_report('اخفاء صورة العميل ' . $user->name);
        $msg = $user->avatar_seen && $user->edit_seen ? 'اظهار' : 'اخفاء';
        return $msg;
    }

    public function review($id)
    {
        $user = User::find($id);
        if (!isset($user)) return back()->with('danger', 'عضو غير موجود');
        return view('dashboard.user_photo', compact('user'));
    }

    public function accept($id)
    {
        $user = User::find($id);
        $user->avatar      = !empty($user->avatar_edit) && $user->edit_seen == 0 ? $user->avatar_edit : $user->avatar;
        $user->avatar_seen = $user->avatar_seen == 1 && $user->edit_seen == 1 ? 0 : 1;
        $user->edit_seen   = 1;
        $user->avatar_edit = null;
        $user->save();
        $data = [
            'title' => 'تحديث الملف الشخصي', 
            'body' => 'تم الموافقة على عرض صورتك الشخصية',
            'btn-text' => 'صفحتي الشخصية',
            'url' => url('show_client/' . $user->id),
            'user' => $user,
        ];
        $user->notify(new ProfilePictureAcceptedNotification($data));
        send_notify($user->id, $data['body'], $data['body'],$data['url']);
        return back()->with('success', 'تم التعديل بنجاح!');
    }

    public function reject($id)
    {
        $user = User::find($id);
        //$user->avatar      = !empty($user->avatar_edit) && $user->edit_seen == 0 ? $user->avatar_edit : $user->avatar;
        $user->avatar_seen = $user->avatar_seen == 1 && $user->edit_seen == 1 ? 0 : 1;
        $user->edit_seen   = 1;
        $user->avatar_edit = null;
        $user->save();
        $data = [
            'title' => 'تحديث الملف الشخصي', 
            'body' => 'تم رفض الصورة الخاصة بك لانها غير مناسبة للنشر في الموقع، برجاء اعادة رفع صورة اخري',
            'btn-text' => 'صفحتي الشخصية',
            'url' => url('show_client/' . $user->id),
            'user' => $user,
        ];
        $user->notify(new ProfilePictureAcceptedNotification($data));
        send_notify($user->id, $data['body'], $data['body'],$data['url']);
        return back()->with('danger', 'تم رفض الصورة');
    }

    public function change_user_status(Request $request)
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
        $user->blocked ? admin_report(' حظر العميل ' . $user->name) : admin_report('ألغاء حظر العميل ' . $user->name);
        $msg = $user->blocked ? Translate('حظر') : Translate('مفعل');
        return $msg;
    }

    public function change_user_see_family(Request $request)
    {
        //check data
        $user = User::whereId($request->id)->first();
        if (!isset($user)) return 0;
        //update data
        $user->see_family = $user->see_family == 1 ? 0 : 1;
        $user->save();

        //add report
        $user->see_family ? admin_report(' رؤية السوق الخيري ' . $user->name) : admin_report('ألغاء رؤية السوق الخيري ' . $user->name);
        $msg = $user->see_family ? 'ظهور' : 'اخفاء';
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

        if ($request->type == 'all'){
            $users = User::where('user_type', 'client')->get();
            foreach ($users as $user) {
                $message = $request->message;
                
                $data    = ['title' => settings('site_name'), 'body' => $message];
                /*foreach (Device::whereUserId($user->id)->get() as $device) {
                    $device_id   = $device->device_id;
                    //if (!is_null($device_id)) send_one_signal($message, $device_id);
                    if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
                }*/
                $data = [
                    'title' => 'لديك إشعار من الأدارة: ', 
                    'body' => 'لديك اشعار من الأدارة، برجاء الاطلاع عليه من هنا',
                    'btn-text' => 'اظهار الرسالة',
                    'url' => url('notifications'),
                    'user' => $user,
                ];
                send_notify($user->id,  $request->message,  $request->message,$data['url'],$data['title']);
                $user->notify(new NewAdminMessageNotification($data));
            }
        }else{
            $user = User::find($request->id);
            $message = $request->message;
            $data = [
                'title' => 'لديك إشعار من الأدارة: ', 
                'body' => 'لديك اشعار من الأدارة، برجاء الاطلاع عليه من هنا',
                'btn-text' => 'اظهار الرسالة',
                'url' => url('notifications'),
                'user' => $user,
            ];
            send_notify($user->id,  $request->message,  $request->message,$data['url'],$data['title']);
            $user->notify(new NewAdminMessageNotification($data));
        }

        return response()->json(['value' => 1, 'msg' => Translate('تم الإرسال بنجاح')]);
    }
}
