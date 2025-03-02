<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Neighborhood;
use App\Models\Role;
use Validator;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class providerController extends Controller
{
    #index
    public function index()
    {
        $data = User::where('user_type' , 'site')->where('supervisor_id' , Auth::id())->get();
        return view('site.providers', compact('data'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required',
            'last_name'        => 'required',
            'email'            => 'required|email|unique:users',
            'phone_code'       => 'required',
            'phone'            => 'required',
            'whatsapp'         => 'nullable',
            'whatsapp_code'    => 'nullable',
            'password'         => 'required',
            'benfit_type'      => 'nullable', // commission , commission_point
            'country_id'       => 'nullable|exists:countries,id',
            'city_id'          => 'nullable|exists:cities,id',
        ],[
            'phone.required'         => ' الجوال مطلوب',
            'phone_code.required'    => 'كود الجوال مطلوب',
            'whatsapp.required'      => ' الواتس اب مطلوب',
            'whatsapp_code.required' => 'كود الواتس اب مطلوب',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        $phone      = $request->phone;
        $phone_code = $request->phone_code;
        $user = User::wherePhone($phone)->wherePhone_code($phone_code)->first();
        if (isset($user)) return response()->json(['value' => 0, 'msg' => trans('api.usedPhone')]);

        /** Save data to users **/
        $code = rand(1111, 9999);
        // $code = 1234;
        /** Send Code To User's Using SMS **/
        // send_mobile_sms_mobily(convert_phone_to_international_format(convert2english($request->phone_code), convert2english($request->phone)), trans('api.activeCode') . $code);

        /** Send Code To User's Using Email**/
        // Mail::to($request->email)->send(new replayMail(trans('api.activeCode') . $code));

        $user     = new User;
        $user->first_name    = $request->first_name;
        $user->last_name     = $request->last_name;
        $user->phone         = convert2english($request->phone);
        $user->phone_code    = $request->phone_code;
        $user->whatsapp      = is_null($request->whatsapp) ? convert2english($request->phone) : convert2english($request->whatsapp);
        $user->whatsapp_code = is_null($request->whatsapp_code) ? $request->phone_code : $request->whatsapp_code;
        $user->email         = $request->email;
        $user->benfit_type   = $request->benfit_type;
        $user->user_type     = 'site';
        $user->country_id    = $request->country_id;
        $user->city_id       = $request->city_id;
        $user->supervisor_id = Auth::id();
        $user->password      = bcrypt($request->password);
        $user->avatar        = 'default.png';
        $user->lang          = 'ar';
        $user->checked       = 1;
        $user->activation    = 1; // not active account
        $user->confirm       = 1;
        $user->code          = $code;
        $user->save();

        /** Send Code To User's Using SMS **/
        // send_mobile_sms_mobily(convert_phone_to_international_format($user->phone_code, $user->phone), trans('api.activeCode') . $user->code);

        // success response
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required',
            'last_name'        => 'required',
            'email'            => 'required|email|unique:users,email,' . $request->id,
            'phone_code'       => 'required',
            'phone'            => 'required',
            'whatsapp'         => 'nullable',
            'whatsapp_code'    => 'nullable',
            'benfit_type'      => 'nullable', // commission , commission_point
            'country_id'       => 'nullable|exists:countries,id',
            'city_id'          => 'nullable|exists:cities,id',
        ],[
            'phone.required'         => ' الجوال مطلوب',
            'phone_code.required'    => 'كود الجوال مطلوب',
            'whatsapp.required'      => ' الواتس اب مطلوب',
            'whatsapp_code.required' => 'كود الواتس اب مطلوب',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update provider
        $user = User::whereId($request->id)->first();
        $user->update($request->except(['_token']));

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete(Request $request)
    {
        #get provider
        $user = User::whereId($request->id)->firstOrFail();
        $name = $user->name;

        #send FCM

        #delete provider
        $user->delete();

        #add adminReport
        admin_report('حذف المسوق ' . $name);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get providers
        if ($type == 'all') $users = User::where('user_type', 'provider')->get();
        else {
            $ids = $request->user_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $user_ids    = explode(',', $second_ids);
            $users = User::whereIn('id', $user_ids)->get();
        }

        foreach ($users as $user) {
            #send FCM

            #delete provider
            $user->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من موظف');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #change provider status (active - blocked)
    public function change_provider_status(Request $request)
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
        $user->blocked ? admin_report(' حظر المسوق ' . $user->name) : admin_report('ألغاء حظر المسوق ' . $user->name);
        $msg = $user->blocked ? Translate('حظر') : Translate('مفعل');
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

        if ($request->type == 'all') $users = User::where('user_type', 'provider')->get();
        else $users = User::whereId($request->id)->get();

        foreach ($users as $user) {
            $message = $request->message;
            #send FCM

            #send notify
            send_notify($user->id, $message, $message);
        }

        return response()->json(['value' => 1, 'msg' => Translate('تم الإرسال بنجاح')]);
    }
}
