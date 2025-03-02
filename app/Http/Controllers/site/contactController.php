<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site_report;
use App\Models\City;
use App\Models\Sub_section;
use App\Models\User_day;
use App\Models\User_check;
use App\Models\User_team;
use App\Models\Contact;
use App\Models\Service_image;
use App\Models\Service_offer;
use App\Models\User_image;
use App\Models\User_time;
use App\Models\User_time_static;
use App\Models\User;
use Validator;
use Auth;
use Session;
use Illuminate\Http\Request;

class contactController extends Controller
{
    #index
    public function index()
    {
        return view('site.contacts');
    }

    public function main_contacts()
    {
        return view('contact');
    }

    #send contact
    public function Contact_Send(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'name'     => 'required',
            'phone'    => 'required',
            'email'    => 'required',
            'message'  => 'required',
        ], [
            'name.required' => 'الاسم مطلوب',
            'phone.required' => 'رقم الجوال مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'message.required' => 'الرسالة مطلوب',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return response()->json(['key' => 'fail', 'value' => 0, 'msg' => $validate->errors()->first()]);

        #store contact us
        $request->request->add(['seen' => '0']);
        Contact::create($request->all());

        /** Send Success Massage **/
        return response()->json(['key' => 'success', 'value' => 1, 'msg' => Translate('تم بنجاح')]);
    }

    #profile
    public function profile($id)
    {
        if (Auth::guest()) return redirect()->route('site_login');
        $user = User::whereId($id)->firstOrFail();
        return view('site.profile', compact('id', 'user'));
    }

    public function rmvImage(Request $request)
    {
        $data = User_image::find($request->id);
        if (!isset($data)) return 'err';

        $count = User_image::where('user_id', $data->user_id)->count();
        if ($count <= 1) return 'err';

        $data->delete();
        return 'success';
    }

    #profile
    public function post_profile(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'photo'      => 'nullable|image',
            'first_name' => 'nullable|max:255',
            'phone'      => 'nullable|min:9|max:13|unique:users,phone,' . $request->id,
            'email'      => 'nullable|max:255|email|unique:users,email,' . $request->id,
            'password'   => 'nullable|min:6|max:255',
        ]);

        #error response
        if ($validator->fails()) return back();
            //return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/users')]);
        #update client
        $user = User::whereId($request->id)->first();
        if (empty($request->password)) $user->update($request->except(['_token', 'photo', 'id_photo', 'by_cash', 'by_transfer', 'by_online', 'photos', 'amounts', 'prices']));
        else $user->update($request->except(['_token', 'photo', 'id_photo', 'password', 'by_cash', 'by_transfer', 'by_online', 'photos', 'amounts', 'prices']));

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return back();
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #doctor profile
    public function post_doctor_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar'            => 'nullable|image',
            'first_name'        => 'required|max:255|unique:users,first_name,' . $request->id,
            'phone'             => 'required|min:9|max:13|unique:users,phone,' . $request->id,
            'email'             => 'required|max:255|email|unique:users,email,' . $request->id,
            'city_id'           => 'required|max:255',
            'sub_section_id'    => 'required|max:255',
            'specialist'        => 'required|max:255',
            'service_type'      => 'required|max:255',
            'wait_time'         => 'nullable|max:255',
            'password'          => 'nullable|min:6|max:255',

        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        if ($request->service_type == 'check') {
            if (is_null($request->total)) return response()->json(['value' => 0, 'msg' => Translate('رسوم الحجز مطلوب')]);
            if (empty($request->start_time)) return response()->json(['value' => 0, 'msg' => Translate('وقت بداية الكشف مطلوب')]);
            if (empty($request->end_time)) return response()->json(['value' => 0, 'msg' => Translate('وقت نهاية الكشف مطلوب')]);
            if (empty($request->days)) return response()->json(['value' => 0, 'msg' => Translate('يجب اختيار يوم للكشف على الاقل')]);
        }

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/users')]);
        #city
        $city = City::whereId($request->city_id)->first();
        $request->request->add(['country_id' => isset($city) ? $city->country_id : null]);
        #sub_section
        $sub_section = Sub_section::whereId($request->sub_section_id)->first();
        $request->request->add(['section_id' => isset($sub_section) ? $sub_section->section_id : null]);

        //dd($request->all());
        #update client
        $user = User::whereId($request->id)->first();
        if (empty($request->password)) $user->update($request->except(['_token', 'photo', 'pac-input', 'days']));
        else $user->update($request->except(['_token', 'photo', 'pac-input', 'days', 'password']));

        #days
        User_day::whereUserId($user->id)->delete();
        foreach ($request->days as $day) {
            User_day::create([
                'day_id'  => $day,
                'user_id' => $user->id
            ]);
        }

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #hospital profile
    public function post_hospital_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar'            => 'nullable|image',
            'first_name'        => 'required|max:255|unique:users,first_name,' . $request->id,
            'phone'             => 'required|min:9|max:13|unique:users,phone,' . $request->id,
            'email'             => 'required|max:255|email|unique:users,email,' . $request->id,
            'city_id'           => 'required|max:255',
            'sub_section_id'    => 'required|max:255',
            'specialist'        => 'required|max:255',
            'password'          => 'nullable|min:6|max:255',

        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);


        if (is_null($request->total)) return response()->json(['value' => 0, 'msg' => Translate('رسوم الحجز مطلوب')]);
        if (empty($request->start_time)) return response()->json(['value' => 0, 'msg' => Translate('وقت بداية العمل مطلوب')]);
        if (empty($request->end_time)) return response()->json(['value' => 0, 'msg' => Translate('وقت نهاية العمل مطلوب')]);
        if (empty($request->days)) return response()->json(['value' => 0, 'msg' => Translate('يجب اختيار يوم للعمل على الاقل')]);

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/users')]);
        #city
        $city = City::whereId($request->city_id)->first();
        $request->request->add(['country_id' => isset($city) ? $city->country_id : null]);
        #sub_section
        $sub_section = Sub_section::whereId($request->sub_section_id)->first();
        $request->request->add(['section_id' => isset($sub_section) ? $sub_section->section_id : null]);
        #update client
        $user = User::whereId($request->id)->first();
        if (empty($request->password)) $user->update($request->except(['_token', 'photo', 'pac-input', 'days']));
        else $user->update($request->except(['_token', 'photo', 'pac-input', 'days', 'password']));

        #days
        User_day::whereUserId($user->id)->delete();
        foreach ($request->days as $day) {
            User_day::create([
                'day_id'  => $day,
                'user_id' => $user->id
            ]);
        }

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #lab profile
    public function post_lab_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar'            => 'nullable|image',
            'first_name'        => 'required|max:255|unique:users,first_name,' . $request->id,
            'phone'             => 'required|min:9|max:13|unique:users,phone,' . $request->id,
            'email'             => 'required|max:255|email|unique:users,email,' . $request->id,
            'city_id'           => 'required|max:255',
            'sub_section_id'    => 'required|max:255',
            'password'          => 'nullable|min:6|max:255',

        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);


        // if(is_null($request->total)) return response()->json(['value' => 0, 'msg' => Translate('رسوم الحجز مطلوب')]);
        if (empty($request->start_time)) return response()->json(['value' => 0, 'msg' => Translate('وقت بداية العمل مطلوب')]);
        if (empty($request->end_time)) return response()->json(['value' => 0, 'msg' => Translate('وقت نهاية العمل مطلوب')]);
        if (empty($request->days)) return response()->json(['value' => 0, 'msg' => Translate('يجب اختيار يوم للعمل على الاقل')]);

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/users')]);
        #city
        $city = City::whereId($request->city_id)->first();
        $request->request->add(['country_id' => isset($city) ? $city->country_id : null]);
        #sub_section
        $sub_section = Sub_section::whereId($request->sub_section_id)->first();
        $request->request->add(['section_id' => isset($sub_section) ? $sub_section->section_id : null]);
        #update client
        $user = User::whereId($request->id)->first();
        if (empty($request->password)) $user->update($request->except(['_token', 'photo', 'pac-input', 'titles_ar', 'titles_en', 'prices', 'days']));
        else $user->update($request->except(['_token', 'photo', 'pac-input', 'days', 'titles_ar', 'titles_en', 'prices', 'password']));

        #days
        User_day::whereUserId($user->id)->delete();
        foreach ($request->days as $day) {
            User_day::create([
                'day_id'  => $day,
                'user_id' => $user->id
            ]);
        }

        #checks
        User_check::whereUserId($user->id)->delete();
        $titles_ar = $request->titles_ar;
        $titles_en = $request->titles_en;
        $prices    = $request->prices;
        foreach ($titles_ar as $key => $item) {
            if (!empty($titles_ar[$key]) && !empty($prices[$key])) {
                User_check::create([
                    'title_ar'  => $titles_ar[$key],
                    'title_en'  => !empty($titles_en[$key]) ? $titles_en[$key] : $titles_ar[$key],
                    'price'     => $prices[$key],
                    'user_id'   => $user->id
                ]);
            }
        }

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #money_request
    public function money_request()
    {
        return view('site.money_request');
    }

    #send money transfer request
    public function send_money_request(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'message'           => 'required',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return response()->json(['key' => 'fail', 'value' => 0, 'msg' => $validate->errors()->first()]);

        /** Save Contact **/
        $user = User::whereId(Auth::id())->first();
        if ($user->commission < $request->message) return response()->json(['key' => 'fail', 'value' => 0, 'msg' => trans('api.notHaveMoney')]);

        $contact   = new Contact;
        $contact->message  = $request->message;
        $contact->user_id  = Auth::id();
        $contact->type     = 'transfer';
        $contact->save();

        Send_FCM_Badge_naitve(['title' => 'transfer', 'msg' => 'لديك تحويل جديد']);

        /** Send Success Massage **/
        return response()->json(['key' => 'success', 'value' => 1, 'msg' => Translate('تم بنجاح')]);
    }

    #money_transfer
    public function money_transfer()
    {
        $data = User::where('supervisor_id', Auth::id())->get();
        return view('site.money_transfer', compact('data'));
    }

    #send money transfer request
    public function send_money_transfer(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'message'    => 'required',
        ]);

        /** Send Error Massages **/
        if ($validate->fails()) return back();

        /** Save Contact **/
        $user = User::whereId($request->to_id)->first();
        if ($user->commission < $request->message) {
            Session::put('danger', Translate('المبلغ المدخل اكبر من العمولة المستحقة'));
            return back();
        }

        $contact   = new Contact;
        $contact->message  = $request->message;
        $contact->user_id  = Auth::id();
        $contact->to_id    = $request->to_id;
        $contact->type     = 'paid';
        $contact->save();

        // Send_FCM_Badge_naitve(['title' => 'transfer', 'msg' => 'لديك تحويل جديد']);

        /** Send Success Massage **/
        Session::put('success', Translate('تم بنجاح'));
        return back();
    }

    #view_transfer
    public function view_transfer()
    {
        $data = Contact::where('to_id', Auth::id())->where('type', 'paid')->get();
        return view('site.view_transfer', compact('data'));
    }

    #send money transfer request
    public function send_replay_transfer($id, $status = 'refused')
    {
        $contact    = Contact::whereId($id)->first();
        if ($status == 'agree') {
            $user       = User::whereId($contact->to_id)->first();
            $supervisor = User::whereId($contact->user_id)->first();
            $message    = (float) $contact->message;

            $add = $user->commission - $message >= 0 ? $message : $user->commission;
            $user->commission      = $user->commission - $add;
            $user->commission_done = $user->commission_done + $add;
            $user->save();

            $supervisor->commission         = $supervisor->commission + $add;
            $supervisor->commission_total   = $supervisor->commission_total + $add;
            $supervisor->save();
        }

        $contact->delete();

        // Send_FCM_Badge_naitve(['title' => 'transfer', 'msg' => 'لديك تحويل جديد']);

        /** Send Success Massage **/
        Session::put('success', Translate('تم بنجاح'));
        return back();
    }

    #index
    public function index_time($id)
    {
        $data = User_time::whereUserId($id)->get();
        return view('site.times', compact('data', 'id'));
    }

    #store
    public function store_time(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new sub_section
        $time = User_time::create($request->except(['_token']));

        foreach (generateTimeRangeWithDate($request->time, $request->end_time, 1, $request->date) as $item) {
            User_time_static::create([
                'user_time_id' => $time->id,
                'user_id' => $request->user_id,
                'count'   => $request->count,
                'date'    => isset($item['date']) ? $item['date'] : $request->date,
                'time'    => isset($item['time']) ? $item['time'] : $request->time,
            ]);
        }

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function update_time(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
        ]);

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update time
        $time = User_time::whereId($request->id)->first();
        $time->update($request->except(['_token']));

        User_time_static::where('user_time_id', $time->id)->delete();
        foreach (generateTimeRangeWithDate($request->time, $request->end_time, 1, $request->date) as $item) {
            User_time_static::create([
                'user_time_id' => $time->id,
                'user_id' => $request->user_id,
                'count'   => $request->count,
                'date'    => isset($item['date']) ? $item['date'] : $request->date,
                'time'    => isset($item['time']) ? $item['time'] : $request->time,
            ]);
        }

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function delete_time(Request $request)
    {
        #get user_time
        $user_time = User_time::whereId($request->id)->firstOrFail();
        $title_ar = $user_time->title_ar;

        #send FCM

        #delete user_time
        $user_time->delete();

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all_time(Request $request)
    {
        $type = $request->type;
        #get user_times
        if ($type == 'all') $user_times = User_time::get();
        else {
            $ids = $request->user_time_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $user_time_ids = explode(',', $second_ids);
            $user_times = User_time::whereIn('id', $user_time_ids)->get();
        }

        foreach ($user_times as $user_time) {
            #send FCM

            #delete user_time
            $user_time->delete();
        }

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
