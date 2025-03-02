<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Service_image;
use App\Models\Contact;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Auth;
use App\Models\Notification as userNotification;

class mainController extends Controller
{
    #lang
    public function language($lang)
    {
        Session()->has('language') ? Session()->forget('language') : '';
        if ($lang == 'ar') {
            Session()->put('language', 'ar');
        } else {
            Session()->put('language', 'en');
        }
        return back();
    }

    #contact seen
    public function contact_seen(Request $request)
    {
        Contact::whereId($request->id)->update(['seen' => true]);
        return true;
    }

    #get neighborhood
    public function get_neighborhood(Request $request)
    {
        $data = Neighborhood::whereCityId($request->city_id)->get();
        return view('ajax.get_neighborhood', compact('data'));
    }

    #home page
    public function home()
    {
        return view('dashboard.index');
    }

    #login page
    public function login()
    {
        /*foreach (User::whereIn('user_type' , ['saler' , 'market'])->get() as $user){
            foreach ($user->sub_sections as $item){
                $first = Service::create([
                    'title_ar' => 'بطيخ',
                    'title_en' => 'Watermalne',
                    'desc_ar'  => 'بطيخ بطيخ بطيخ',
                    'desc_en'  => 'Watermalne Watermalne Watermalne',
                    'price'    => '10',
                    'amount'   => '100',
                    'unit'     => 'الكيلو جرام',
                    'user_id'  => $user->id,
                    'section_id' => $item->id,
                ]);

                Service_image::create([
                    'image'       => '/public/images/services/08-02-211612768992517618184.jpeg',
                    'service_id'  => $first->id,
                ]);

                ############################################################################

                $second = Service::create([
                    'title_ar' => 'برتقال',
                    'title_en' => 'Orange',
                    'desc_ar'  => 'برتقال برتقال برتقال',
                    'desc_en'  => 'Orange Orange Orange',
                    'price'    => '20',
                    'amount'   => '200',
                    'unit'     => 'الكيلو جرام',
                    'user_id'  => $user->id,
                    'section_id' => $item->id,
                ]);

                Service_image::create([
                    'image'       => '/public/images/services/16-02-211613513747179363260.jpg',
                    'service_id'  => $second->id,
                ]);

                ############################################################################

                $item->update(['main_section_id' => $user->section_id]);
                foreach ($item->services as $servic){
                    $servic->update(['main_section_id' => $user->section_id]);
                }
            }
        }*/
        return view('dashboard.login');
    }

    #login post
    public function post_login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'      => 'required|email',
                'password'   => 'required|min:6',
            ]
        );

        #error response
        if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #login success
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            #update user's device
            if (!is_null($request->device_id)) update_device(Auth::user(), $request->device_id, 'web');
            #Success response
            return response()->json(['value' => 1, 'msg' => Translate('تم تسجيل الدخول بنجاح')]);
        }

        #faild response
        return response()->json(['value' => 0, 'msg' => Translate('البيانات غير صحيحة قم بإعادة المحاولة')]);
    }

    #logout page
    public function logout()
    {
        Auth::logout();
        return back();
    }

    public function adminAllNotifications()
    {
        $notifications = userNotification::where('to_id', auth()->id())->orderBy('id', 'desc')->paginate(5);
        return view('dashboard.allnotifications')->with('notifications',$notifications);
    }
    public function markAllNotificationsRead()
    {
        $notifications = userNotification::where('to_id', auth()->id())->where('seen', 0)->get();
        foreach($notifications as $notification)
        {
            $notification->seen = 1 ;
            $notification->update();
        }
        return response()->json(['value' => 1]);
    }
}
