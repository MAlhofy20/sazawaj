<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Role;
use App\Models\City;
use App\Models\Page;
use App\Models\Media_file;
use App\Models\Speaker;
use App\Models\Slider;
use App\Models\Package;
use App\Models\Mail_list;
use App\Models\User_image;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Favourite;
use App\Models\Visitor;
use App\Models\User_block_list;
use App\Models\Room;
use App\Models\Room_chat;
use App\Models\Device;
use App\Models\User;
use App\Models\Notification as userNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\replayMail;
use Session;
use Auth;
use Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfilePictureChangeNotification;
use App\Notifications\ProfilePictureCheckNotification;
use App\Notifications\AddToFavouriteNotification;
use App\Notifications\ProfileSeenNotification;
use App\Notifications\SubscripePackageNotification;
use App\Notifications\NewMessageNotification;
use App\Notifications\NewContactUsMessageNotification;
use App\Notifications\NewAccountNotification;
use App\Mail\VerificationCodeMailable;

use function GuzzleHttp\json_encode;

class mainController extends Controller
{
    public function __construct()
    {
        //genrateFireBaseAccessToken();
        //agoraApi();

        //$token = 'epKDHdBjxm4ol_dLW-Zgpi:APA91bH758LqGzMqqXco5nehRglo7G2hgAzYGFOwHqNyVY7Q5mEiTvkd9i8MN3y4AkTWqSZR8rS0GnOpKwomss76vp-h_fpqYSRACvPZKRHZ_tHXE3IcG28';
        //sendFCMNotificationToWeb($token, ['title' => 'hi', 'body' => 'bye'], url('admin-panel'));

        //$title = "<html><head><title></title></head><body dir='rtl' style='text-align: right'>test</body></html>";
        //send_mail_html('lovedayar91@gmail.com', $title);
    }

    #lang
    public function language($lang)
    {
        Session()->has('language') ? Session()->forget('language') : '';
        if ($lang == 'en') {
            Session()->put('language', 'en');
        } else {
            Session()->put('language', 'ar');
        }
        return back();
    }

    #ui_page
    public function ui_page($name)
    {
        return view('site.ui.' . $name);
    }

    public function search_by_keywords(Request $request)
    {
        $data = Service::where('show', '1')->whereDate('date', '>=', Carbon::now())->where('keywords', 'like', '%' . $request->keywords . '%')->get();
        return view('ajax.search_by_keywords', compact('data'));
    }

    #contact seen
    public function contact_seen(Request $request)
    {
        Contact::whereId($request->id)->update(['seen' => true]);
        return true;
    }

    #static page
    public function static_home()
    {
        return view('site-index');
    }

    public function search()
    {
        return view('site.search');
    }

    public function package_info()
    {
        return view('site.package_info');
    }

    public function notifications()
    {
        $notifications = userNotification::where('to_id', auth()->id())->orderBy('id', 'desc')->paginate(5);
        return view('site.notifications')->with('notifications',$notifications);
    }

    public function notificationsMarkAsRead()
    {
        $notifications = userNotification::where('to_id', auth()->id())->where('seen', 0)->get();
        foreach($notifications as $notification)
        {
            $notification->seen = 1 ;
            $notification->update();
        }
        return response()->json(['value' => 1]);
    }

    public function notificationsCount()
    {
        $hasNotifications = 0;
        if(userNotification::where('to_id', auth()->id())->where('seen', 0)->count() > 0)
        {
            $hasNotifications = 1 ;
        }
        return response()->json(['count' => $hasNotifications]);
    }

    public function questions()
    {
        return view('site.questions');
    }

    #partners page
    public function common_question()
    {
        return view('site.common_question');
    }

    public function partners()
    {
        return view('site.partners');
    }

    #all_branches page
    public function all_branches()
    {
        return view('site.all_branches');
    }

    #show_branche page
    public function show_branche($id)
    {
        $item = Branch::whereId($id)->firstOrFail();
        return view('site.show_branche', compact('item'));
    }

    public function all_services()
    {
        return view('site.all_services');
    }

    public function all_clients(Request $request)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        $blocked = User_block_list::where('user_id', auth()->id())->pluck('to_id')->toArray();
        //$favourites = Favourite::where('user_id', auth()->id())->pluck('to_id')->toArray();
        $blocked_and_favourites = array_merge($blocked, [auth()->id()]);

        //inRandomOrder()
        $query = User::query();
        $query->where('user_type', 'client');
        $query->where('blocked', '0');
        $query->where('avatar_seen', '1');
        $query->whereNotIn('id', $blocked_and_favourites);
        if (isset($queries['first_name']) && !empty($queries['first_name'])) {
            $query->where(function ($q) use ($queries) {
                $q->where('first_name', 'like', '%' . $queries['first_name'] . '%');
            });
        }
        if (isset($queries['goals']) && !empty($queries['goals'])) {
            $query->where(function ($q) use ($queries) {
                $q->where('goals', 'like', '%' . $queries['goals'] . '%');
            });
        }
        if (isset($queries['login']) && !empty($queries['login'])) {
            $query->whereHas('sessions', function ($query) {
                $query->latest('last_activity')->limit(1) // جلب أحدث جلسة فقط
                      ->where('last_activity', '>=', Carbon::now()->subHours(2)->timestamp);
            });
        }

        if (isset($queries['logout_at']) && ((string) $queries['logout_at'] == '0' || (int) $queries['logout_at'] > 0)) {
            $days = (int) $queries['logout_at'];
            $logout_at = $days > 0 ? Carbon::now()->subDays($days) : Carbon::now();
            $query->whereDate('logout_date', '>=', $logout_at);
        }

        if (isset($queries['created_at']) && ((string) $queries['created_at'] == '0' || (int) $queries['created_at'] > 0)) {
            $days = (int) $queries['created_at'];
            $created_at = $days > 0 ? Carbon::now()->subDays($days) : Carbon::now();
            $query->whereDate('created_at', '>=', $created_at);
        }

        if (isset($queries['city']) && !empty($queries['city'])) {
            $query->where('city', $queries['city']);
        }
        if (isset($queries['gender']) && !empty($queries['gender'])) {
            $query->where('gender', $queries['gender']);
        }
        if (isset($queries['age']) && !empty($queries['age'])) {
            $query->where('age', $queries['age']);
        }
        if (isset($queries['social_level']) && !empty($queries['social_level'])) {
            $query->where('social_level', $queries['social_level']);
        }
        if (isset($queries['has_sons']) && ((string) $queries['has_sons'] == '0' || (string) $queries['has_sons'] == '1')) {
            $query->where('has_sons', $queries['has_sons']);
        }
        if (isset($queries['level']) && !empty($queries['level'])) {
            $query->where('level', $queries['level']);
        }
        if (isset($queries['eye_color']) && !empty($queries['eye_color'])) {
            $query->where('eye_color', $queries['eye_color']);
        }
        if (isset($queries['hair_color']) && !empty($queries['hair_color'])) {
            $query->where('hair_color', $queries['hair_color']);
        }
        if (isset($queries['skin_color']) && !empty($queries['skin_color'])) {
            $query->where('skin_color', $queries['skin_color']);
        }
        if (isset($queries['height']) && !empty($queries['height'])) {
            $query->where('height', $queries['height']);
        }
        if (isset($queries['width']) && !empty($queries['width'])) {
            $query->where('width', $queries['width']);
        }
        $query->orderBy('created_at', 'desc');
        $data = $query->get();

        return view('site.all_clients', ['data' => $data]);
    }

    public function all_fav_clients(Request $request)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        Favourite::where('to_id', '!=', auth()->id())->where('user_id', auth()->id())->update(['seen' => '1']);

        $data = Favourite::has('user')->has('to')->where('to_id', '!=', auth()->id())
            ->where('user_id', auth()->id())->orderBy('updated_at', 'desc')
            ->where('show_in_list', '1')
            ->get();
        $to_data = Favourite::has('user')->has('to')->where('user_id', '!=', auth()->id())->where('to_id', auth()->id())->orderBy('updated_at', 'desc')->get();

        //$favourites = Favourite::where('to_id', '!=', auth()->id())->where('user_id', auth()->id())->orderBy('updated_at', 'desc')->pluck('to_id')->toArray();
        //$to_favourites = Favourite::where('user_id', '!=', auth()->id())->where('to_id', auth()->id())->orderBy('updated_at', 'desc')->pluck('user_id')->toArray();

        //inRandomOrder()
        /*$query = User::query();
        $query->where('user_type', 'client');
        $query->where('blocked', '0');
        $query->where('avatar_seen', '1');
        $query->whereIn('id', $favourites);
        //$query->orderBy('created_at', 'desc');
        $data = $query->get();*/

        /*$to_query = User::query();
        $to_query->where('user_type', 'client');
        $to_query->where('blocked', '0');
        $to_query->where('avatar_seen', '1');
        $to_query->whereIn('id', $to_favourites);
        //$to_query->orderBy('created_at', 'desc');
        $to_data = $to_query->get();*/

        return view('site.all_fav_clients', ['data' => $data, 'to_data' => $to_data]);
    }

    public function all_blocked_clients(Request $request)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        $data = User_block_list::has('user')->has('to')->where('to_id', '!=', auth()->id())->where('user_id', auth()->id())->orderBy('updated_at', 'desc')->get();
        $to_data = User_block_list::has('user')->has('to')->where('user_id', '!=', auth()->id())->where('to_id', auth()->id())->orderBy('updated_at', 'desc')->get();

        //$blocked = User_block_list::where('to_id', '!=', auth()->id())->where('user_id', auth()->id())->orderBy('updated_at', 'desc')->pluck('to_id')->toArray();
        //$to_blocked = User_block_list::where('user_id', '!=', auth()->id())->where('to_id', auth()->id())->orderBy('updated_at', 'desc')->pluck('user_id')->toArray();

        //inRandomOrder()
        /*$query = User::query();
        $query->where('user_type', 'client');
        $query->where('blocked', '0');
        $query->where('avatar_seen', '1');
        $query->whereIn('id', $blocked);
        $data = $query->get();*/

        /*$to_query = User::query();
        $to_query->where('user_type', 'client');
        $to_query->where('blocked', '0');
        $to_query->where('avatar_seen', '1');
        $to_query->whereIn('id', $to_blocked);
        $to_data = $to_query->get();*/

        return view('site.all_blocked_clients', ['data' => $data, 'to_data' => $to_data]);
    }

    public function all_visitor_clients(Request $request)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        Visitor::where('to_id', auth()->id())->update(['seen' => '1']);
        $data = Visitor::has('user')->has('to')->where('to_id', '!=', auth()->id())->where('user_id', auth()->id())->orderBy('updated_at', 'desc')->get();
        $to_data = Visitor::has('user')->has('to')->where('user_id', '!=', auth()->id())->where('to_id', auth()->id())->orderBy('updated_at', 'desc')->get();
        //dd($data, $to_data);
        //inRandomOrder()
        /*$query = User::query();
        $query->where('user_type', 'client');
        $query->where('blocked', '0');
        $query->where('avatar_seen', '1');
        $query->whereIn('id', $visitor);
        $data = $query->get();*/

        /*$to_query = User::query();
        $to_query->where('user_type', 'client');
        $to_query->where('blocked', '0');
        $to_query->where('avatar_seen', '1');
        $to_query->whereIn('id', $to_visitor);
        $to_data = $to_query->get();*/

        return view('site.all_visitor_clients', ['data' => $data, 'to_data' => $to_data]);
    }

    public function show_client($id)
    {
        if (auth()->check()) {
        if (auth()->user()->user_type == 'client') {
            //if(!checkUserPackage() && auth()->id() != $id) return redirect('all_packages');
            if(auth()->id() != $id)
            {
                $visitor = Visitor::where('user_id', auth()->id())->where('to_id', $id)->first();
                if (!isset($visitor)){
                    $visitor = Visitor::create(['user_id' => auth()->id(), 'to_id' => $id, 'seen' => '0']);
                    $user = User::find($id);
                    $visitorUser = User::find($visitor->user_id);
                    $data = [
                        'title' => 'لديك زيارة جديد',
                        'body' => 'لقد قام شخص بزيارة صفحتك الشخصية',
                        'btn-text' => 'شاهد صفحته',
                        'visitor' => $visitorUser,
                        'url' => url('show_client/' . $visitor->user_id),
                        'user' => $user
                    ];
                    send_notify($user->id, $data['body'], $data['body'], $data['url']);
                    $user->notify(new ProfileSeenNotification($data));
                }
                else{
                    $visitor->update(['updated_at' => Carbon::now()]);
                }
            }

        }
        #query string
        }
        $data = User::whereId($id)->firstOrFail();
        $favouritted = Favourite::where('user_id', auth()->id())->where('to_id', $id)->first();

        return view('site.show_client', ['data' => $data, 'favouritted' => $favouritted]);
    }

    public function all_packages()
    {
        #query string
        #get client
        $data = Package::get();

        return view('site.all_packages', ['data' => $data]);
    }

    public function subscripe_package($id)
    {
        #subscripe package
        $package = Package::whereId($id)->firstOrFail();
        $amount = (int) $package->amount;
        $price = (int) $package->price;
        $user = auth()->user();
        $user->update([
            'package_id' => $id,
            'package_title' => $package->title_ar,
            'price' => $price,
            'renewal_price' => $price,
            'package_date' => Carbon::now(),
            'package_end_date' => Carbon::now()->addMonths($amount),
        ]);

        $data = [
            'title' => 'أشتراك جديد',
            'header' => 'مبروك! اشتراكك في العضوية الجديدة',
            'body' => 'ابدأ بأول خطوة لأيجاد الشريك المناسب لك',
            'package' => $package,
            'btn-text' => 'شاهد الأعضاء',
            'url' => url('search'),
            'user' => $user->first_name,
        ];
        send_notify($user->id, $data['header'], $data['header'], $data['url']);
        $user->notify(new SubscripePackageNotification($data));

        Session::flash('success', 'تم الاشتراك بنجاح');
        return redirect('/');
    }

    public function all_rooms()
    {
        //if(!checkUserPackage()) return redirect('all_packages');

        #query string
        #get client
        $query = Room::query();
        $query->has('chats');
        $query->has('user');
        $query->has('saler');
        // $query->whereIn('show_ids');
        $query->where('user_id', auth()->id())->where('show_user_id',1)
              ->orWhere(function ($query) {
                  $query->where('saler_id', auth()->id())->where('show_saler_id',1);
              });



        $rooms = $query->get();
        $data = $rooms->sortByDesc(function ($q, $key) {
            return $q->chats->max('created_at');
        })->all();

        return view('site.all_rooms', ['data' => $data]);
    }

    public function show_chat($id)
    {
        if (!checkUserPackage())
            return redirect('all_packages');

        #get room
        $room = Room::where(function ($q) use ($id) {
            return $q->where('user_id', auth()->id())->where('saler_id', $id);
        })->first();

        if (!isset($room)) {
            $room = Room::where(function ($q) use ($id) {
                return $q->where('saler_id', auth()->id())->where('user_id', $id);
            })->first();
        }
        if (!isset($room)) {
            $room = Room::create(['user_id' => auth()->id(), 'saler_id' => $id]);
        }

        $data = $room->chats;
        $favouritted = Favourite::where('user_id', auth()->id())->where('to_id', $id)->first();


        return view('site.show_chat', ['room' => $room, 'data' => $data, 'favouritted' => $favouritted]);
    }

    public function show_room($id)
    {
        if (!checkUserPackage())
            return redirect('all_packages');

        #get room
        $room = Room::whereId($id)->firstOrFail();
        $data = $room->chats;

        Room_chat::where('room_id', $room->id)->where('to_id', auth()->id())->update(['seen' => '1']);

        return view('site.show_chat', ['room' => $room, 'data' => $data]);
    }

    public function ajax_show_room($id)
    {
        #get room
        $room = Room::whereId($id)->firstOrFail();
        $data = Room_chat::where('room_id', $id)->latest()->take(100)->get()->sortBy('id');

        return view('ajax.show_chat', ['room' => $room, 'data' => $data]);
    }

    public function store_chat(Request $request)
    {
        //dd($request->all());
        $room = Room::whereId($request->room_id)->first();
        if (!isset($room)) {
            $room = Room::where(function ($q) use ($request) {
                return $q->where('user_id', $request->from_id)->where('saler_id', $request->to_id);
            })->first();
        }
        if (!isset($room)) {
            $room = Room::where(function ($q) use ($request) {
                return $q->where('saler_id', $request->from_id)->where('user_id', $request->to_id);
            })->first();
        }
        if (!isset($room)) {
            $room = Room::create(['user_id' => $request->from_id, 'saler_id' => $request->to_id]);
        }

        if (check_user_block_list($request->from_id, $request->to_id)) {
            return back()->with('danger', 'لا يمكن ارسال رسالة لهذا العضو');
        }
        if($room->show_user_id != 1)
        {
            $room->update([
                'show_user_id' => 1,
            ]);
        }else if($room->show_saler_id != 1){
            $room->update([
                'show_saler_id' => 1,
            ]);
        }


        $user = User::find($request->to_id);
        $sender = User::find($request->from_id);
        $message = $request->message;

        if ($request->has('message') && !empty($request->message)) {
            $request->request->add([
                'type' => 'text',
            ]);
            $chat_message = Room_chat::create($request->except(['lang', 'file_path']));

            if (isset($user)) {
                foreach (Device::where('user_id', $user->id)->pluck('device_id') as $token) {
                    sendFCMNotificationToWeb($token, ['title' => auth()->user()->name, 'body' => $request->message], url('show_chat/' . $room->id));
                }

                // $name = auth()->user()->name;
                // $message = $request->message;
                // $title = "<html><head><title></title></head><body dir='rtl' style='text-align: right'><p>لديك رسالة جديدة</p><p>$name :</p><p>$message</p></body></html>";
                // //send_mail_html($user->email, $title);

            }
        }

        if ($request->hasFile('file_path')) {
            $file = upload_image($request->file('file_path'), 'images/users');
            $request->request->add([
                'message' => $file,
                'type' => 'file',
            ]);
            $chat_message = Room_chat::create($request->except(['lang', 'file_path']));

            if (isset($user)) {
                foreach (Device::where('user_id', $user->id)->pluck('device_id') as $token) {
                    sendFCMNotificationToWeb($token, ['title' => auth()->user()->name, 'body' => 'رسالة صوتية'], url('show_chat/' . $room->id));
                }

                // $name = auth()->user()->name;
                $message = 'رسالة صوتية';
                // $title = "<html><head><title></title></head><body dir='rtl' style='text-align: right'><p>لديك رسالة جديدة</p><p>$name :</p><p>$message</p></body></html>";
                // //send_mail_html($user->email, $title);
            }
        }

        // get latest chat_message exept current
        $latest_chat_message = Room_chat::where('id', '!=', $chat_message->id)
            ->where('from_id', $request->from_id)
            ->where('to_id', $request->to_id)
            ->latest()->first();
        $can_send_email = true;

        if ($latest_chat_message) {
            $fiveMinutesAgo = Carbon::now()->subMinutes(5);

            if ($latest_chat_message->created_at > $fiveMinutesAgo) {
                $can_send_email = false;
            }
        }


        $data = [
            'title' => 'لديك رسالة جديدة',
            'body' => 'وصلتك رسالة جديدة',
            'btn-text' => 'اقرأ الرسالة',
            'sender' => $sender,
            'message' => $message,
            'url' => url('show_room/' . $request->room_id),
            'user' => $user,
            'can_send_email' => $can_send_email
        ];

        $user->notify(new NewMessageNotification($data));

        return back();
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    public function post_test(){
        $user = User::find(1);
        $data = [
            'title' => 'رسالة جديدة',
            'body' => 'لديك رسالة جديدة في قسم تواصل معنا',
            'btn-text' => 'اقرأ الرسالة',
            'url' => url('contacts/contact'),
            'admin' => $user,
        ];
        send_notify($user->id, $data['body'], $data['body'], $data['url']);
        $user->notify(new NewContactUsMessageNotification($data));
        return view('emails.contact_us')->with('data',$data);
    }
    public function delete_rooms(Request $request)
    {
        if (!checkUserPackage())
        {
            return redirect('all_packages');
        }
        $user = Auth::user();
        $roomIds = $request->input('room_ids');
        if ($roomIds) {
            // Delete the selected rooms
            //Room_chat::whereIn('id', $roomIds)->delete();
            Room::whereIn('id', $roomIds)->where('user_id', $user->id)->update([
                'show_user_id' => 0
            ]);
            Room::whereIn('id', $roomIds)->where('saler_id', $user->id)->update([
                'show_saler_id' => 0
            ]);

            return redirect()->route('site_all_rooms')->with('success', 'تم حذف الغرف المحددة بنجاح.');
        }

        return redirect()->route('site_all_rooms')->with('error', 'يرجى تحديد غرفة واحدة على الأقل.');

        //return redirect()->route('site_all_rooms');
    }

    public function add_to_favourite($id)
    {
        //if(!checkUserPackage()) return redirect('all_packages');

        #check Favourite
        $fav = Favourite::where('user_id', auth()->id())->where('to_id', $id)->first();
        $user = auth()->user();
        $favourited = User::find($id);
        if (isset($fav))
            // toggle show_in_list
            $fav->update(['show_in_list' => $fav->show_in_list == 0 ? 1 : 0]);

        else {
            $fav_count = Favourite::where('user_id', auth()->id())->count();
            if (!checkUserPackage() && $fav_count == 2)
                return redirect('all_packages');

            Favourite::create(['user_id' => auth()->id(), 'to_id' => $id, 'seen' => '0']);
            $data = [
                'title' => 'لديك معجب جديد',
                'body' => 'لقد قام شخص بأرسال اعجاب اليك',
                'btn-text' => 'تبادل الاعجاب',
                'liker' => $user,
                'url' => url('show_client/' . $user->id),
                'user' => $favourited,
            ];
            send_notify($favourited->id, $data['body'], $data['body'], $data['url']);
            $favourited->notify(new AddToFavouriteNotification($data));
        }

        return back()->with('success', 'تم بنجاح');
    }

    public function add_to_block_list($id)
    {
        $block_list = User_block_list::where('user_id', auth()->id())->where('to_id', $id)->first();

        if (isset($block_list))
            $block_list->delete();
        else
            User_block_list::create(['user_id' => auth()->id(), 'to_id' => $id, 'seen' => '0']);

        return back()->with('success', 'تم بنجاح');
    }

    #contact_us page
    public function contact_us($type)
    {
        return view('site.contact_us', ['type' => $type]);
    }

    #post_contact_us page
    public function post_contact_us(Request $request)
    {
        #store contact us
        $request->request->add(['seen' => '0']);
        Contact::create($request->all());

        // foreach (Device::has('admin')->pluck('device_id') as $token) {
        //     sendFCMNotificationToWeb($token, ['title' => 'رسالة جديدة', 'body' => 'وصلتك رسالة في قسم تواصل معنا'], url('contacts/contact'));
        // }

        // $title = "<html><head><title></title></head><body dir='rtl' style='text-align: right'><p>لديك رسالة في قسم تواصل معنا</p><p>يرجى الاطلاع على الرسالة</p></body></html>";
        // send_mail_html(settings('email'), $title);
        $adminUsers = User::where('user_type','admin')->get();
        foreach($adminUsers as $adminUser)
        {
            $data = [
                'title' => 'رسالة جديدة',
                'body' => 'لديك رسالة جديدة في قسم تواصل معنا',
                'btn-text' => 'اقرأ الرسالة',
                'url' => url('contacts/contact'),
                'admin' => $adminUser,
            ];
            send_notify($adminUser->id, $data['body'], $data['body'], $data['url']);
            $adminUser->notify(new NewContactUsMessageNotification($data));
        }

        #success response
        session()->flash('success', Translate('تم الارسال بنجاح'));
        return back();
    }

    #mail_list
    public function mail_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #check email
        $check = Mail_list::whereEmail($request->email)->first();
        if (isset($check))
            return response()->json(['value' => 0, 'msg' => Translate('البريد الالكتروني مشترك بالفعل')]);

        #store Mail_list
        Mail_list::create($request->except(['_token']));

        #success response
        return response()->json(['value' => 1, 'msg' => Translate('تم الاشتراك بنجاح')]);
    }

    #condition page
    public function page($title)
    {
        $page = Page::whereUrl($title)->orWhere('id', $title)->firstOrFail();
        // if ($title == 'about')        return view('site.page.about', compact('page'));
        // if ($title == 'vission')      return view('site.page.vission', compact('page'));
        // if ($title == 'message')      return view('site.page.message', compact('page'));
        // if ($title == 'app_comments') return view('site.page.app_comments', compact('page'));
        // if ($title == 'media')        return view('site.page.media', compact('page'));
        // if ($title == 'privacy')      return view('site.page.privacy', compact('page'));
        return view('site.page', compact('page'));
    }

    #media_center page
    public function media_center($type)
    {
        $data = Media_file::whereType($type)->get();
        if ($type == 'news')
            return view('site.news', compact('data'));
        if ($type == 'reports')
            return view('site.media_center.reports', compact('data'));
        if ($type == 'meetings')
            return view('site.media_center.meetings', compact('data'));
        if ($type == 'dialogues')
            return view('site.media_center.dialogues', compact('data'));
        if ($type == 'videos')
            return view('site.media_center.videos', compact('data'));
        if ($type == 'photos')
            return view('site.media_center.photos', compact('data'));
        if ($type == 'services')
            return view('site.media_center.services', compact('data'));
    }

    #show_media page
    public function show_media($media_id)
    {
        $data = Media_file::whereId($media_id)->firstOrFail();
        // if($data->type == 'services' && Auth::guest()) return redirect('register');
        $data->update(['seen' => $data->seen + 1]);
        return view('site.show_news', ['data' => $data]);
    }

    #show_slider page
    public function show_slider($slider_id)
    {
        $data = Slider::whereId($slider_id)->firstOrFail();
        $data->update(['seen' => $data->seen + 1]);
        return view('site.show_slider', ['data' => $data]);
    }

    #condition page
    public function condition()
    {
        $page = Page::whereUrl('support')->first();
        return view('policy', compact('page'));
    }

    #condition page
    public function support()
    {
        $page = Page::whereUrl('support')->first();
        return view('policy', compact('page'));
    }

    #condition page
    public function privacy()
    {
        $page = Page::whereUrl('condition')->first();
        return view('policy', compact('page'));
    }

    #home page
    public function index()
    {
        if (auth()->check() && auth()->user()->user_type == 'client') {
            $blocked = User_block_list::where('user_id', auth()->id())->pluck('to_id')->toArray();
            $blocked_from = User_block_list::where('to_id', auth()->id())->pluck('user_id')->toArray();
            $favourites = Favourite::where('user_id', auth()->id())->pluck('to_id')->toArray();
            $blocked_and_favourites = array_merge($blocked, $blocked_from, $favourites, [auth()->id()]);

            $random_users = User::where('gender', '!=', auth()->user()->gender)
                ->where('user_type', 'client')
                ->where('blocked', '0')
                ->where('avatar_seen', '1')
                ->whereNotIn('id', $blocked_and_favourites)
                ->inRandomOrder()
                ->paginate(10);

            $new_users = User::where('gender', '!=', auth()->user()->gender)
                ->where('user_type', 'client')
                ->where('blocked', '0')
                ->where('avatar_seen', '1')
                ->whereNotIn('id', $blocked_and_favourites)
                ->latest()
                ->paginate(10);

            return view('site.index_after_login', [
                'random_users' => $random_users,
                'new_users' => $new_users,
            ]);
        }
        return view('site.index');
    }

    #home page
    public function home()
    {
        if (auth()->check() && auth()->user()->user_type == 'client') {
            $blocked = User_block_list::where('user_id', auth()->id())->pluck('to_id')->toArray();
            $blocked_from = User_block_list::where('to_id', auth()->id())->pluck('user_id')->toArray();
            $favourites = Favourite::where('user_id', auth()->id())->pluck('to_id')->toArray();
            $blocked_and_favourites = array_merge($blocked, $blocked_from, $favourites, [auth()->id()]);

            $random_users = User::where('gender', '!=', auth()->user()->gender)
                ->where('user_type', 'client')
                ->where('blocked', '0')
                ->where('avatar_seen', '1')
                ->whereNotIn('id', $blocked_and_favourites)
                ->inRandomOrder()
                ->paginate(5);

            $new_users = User::where('gender', '!=', auth()->user()->gender)
                ->where('user_type', 'client')
                ->where('blocked', '0')
                ->where('avatar_seen', '1')
                ->whereNotIn('id', $blocked_and_favourites)
                ->latest()
                ->paginate(5);
            $messageCounter = Room::where(function($q) { return $q->where('user_id', auth()->id())->orWhere('saler_id', auth()->id());})->whereHas('chats', function ($q) {$q->where('seen', 0)->where('to_id', auth()->id());})->count();
            $visitorCounter = Visitor::has('user')->whereHas('user', function($q) {return $q->where('user_type', 'client');})->where('user_id', '!=', auth()->id())->where('to_id', auth()->id())->where('seen', '0')->count();
            $likerCounter = Favourite::where('to_id', '!=', auth()->id())->where('user_id', auth()->id())->where('seen', '0')->count();

            return view('site.index_after_login', [
                'random_users' => $random_users,
                'new_users' => $new_users,
                'messageCounter' => $messageCounter,
                'visitorCounter' => $visitorCounter,
                'likerCounter' => $likerCounter
            ]);
        }
        return view('site.index');
    }

    #profile
    public function profile()
    {
        if (auth()->guest())
            return redirect()->route('site_login');
        return view('site.profile');
    }


    #profile
    public function post_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|image',
            'id_photo' => 'nullable',
            'first_name' => 'nullable|max:255',
            //'phone'      => 'nullable|min:9|max:13|unique:users,phone,' . auth()->id(),
            'email' => 'nullable|max:255|email|unique:users,email,' . auth()->id(),
            // 'password'   => 'nullable|min:6|max:255',
            'address' => 'nullable|max:255',

        ]);

        #error response
        if ($validator->fails()) {
            session()->flash('errors', $validator->errors());
            return back();
        }
        // return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #avatar
        if ($request->hasFile('photo')) {
            $request->merge([
        'avatar_edit' => upload_image($request->file('photo'), 'images/users'),
        'edit_seen' => '0'
    ]);
            $user = auth()->user();
            // foreach (Device::has('admin')->pluck('device_id') as $token) {
            //     sendFCMNotificationToWeb($token, ['title' => 'طلب جديد', 'body' => 'قام عميل بتغيير الصورة الشخصية الخاصة به'], url('users') . '?edit=1');
            // }

            //$title = "<html><head><title></title></head><body dir='rtl' style='text-align: right'><p>قام عميل بطلب تغير الصورة الشخصية الخاصة به</p><p>يرجى الاطلاع على الصورة للموافقة</p></body></html>";
            //send_mail_html(settings('test-email'), $title);
            $adminUsers = User::where('user_type','admin')->get();
            foreach($adminUsers as $adminUser)
            {
                $data = [
                    'title' => 'طلب جديد',
                    'body' => 'قام عميل بتغيير الصورة الشخصية الخاصة به، يرجى الاطلاع على الصورة للموافقة',
                    'btn-text' => 'مراجعة الأن',
                    'url' => url('user/review/'.$user->id),
                    'admin' => $adminUser,
                ];
                send_notify($adminUser->id, $data['body'], $data['body'], $data['url']);
                $adminUser->notify(new ProfilePictureChangeNotification($data));
            }
            $data2 = [
                'title' => 'طلب جديد',
                'body' => 'الصورة قيد المراجعة من قبل الأدارة،سيتم نشرها خلال 24 ساعة',
                'btn-text' => 'حسابي',
                'url' => url('site_profile'),
                'user' => $user,
            ];
            send_notify($user->id, $data2['body'], $data2['body'], $data2['url']);
            $user->notify(new ProfilePictureCheckNotification($data2));


        }
        #city
        $city = City::whereId($request->city_id)->first();
        $request->request->add(['country_id' => isset($city) ? $city->country_id : null]);
        if ($request->has('goals'))
            $request->request->add(['goals' => implode(',', $request->goals)]);
        #update client
        $user = User::whereId(auth()->id())->first();
        if ($request->has('password'))
            $user->update($request->except(['_token', 'photo']));
        else
            $user->update($request->except(['_token', 'photo', 'password']));

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return back();
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    public function post_update_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email|unique:users,email,' . auth()->id(),
            'password' => 'required|min:6|max:255',

        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #check password
        $oldPassword = $request->input('password');
        $hashedPassword = auth()->user()->password;
        if (!Hash::check($oldPassword, $hashedPassword))
            return response()->json(['value' => 0, 'msg' => 'كلمة المرور غير صحيحة']);

        #update email
        User::whereId(auth()->id())->update(['email' => $request->email]);

        #success response
        /*session()->flash('success', Translate('تم التعديل بنجاح'));
        return back();*/
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    public function post_update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6|max:255',

        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #check password
        $oldPassword = $request->input('old_password');
        $hashedPassword = auth()->user()->password;
        if (!Hash::check($oldPassword, $hashedPassword))
            return response()->json(['value' => 0, 'msg' => 'كلمة المرور القديمة غير صحيحة']);

        #update password
        User::whereId(auth()->id())->update(['password' => bcrypt($request->password)]);

        #success response
        /*session()->flash('success', Translate('تم التعديل بنجاح'));
        return back();*/
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #active page
    public function active($id)
    {
        #get user
        $user = User::whereId($id)->first();
        #check if user exist
        if (!isset($user))
            return redirect('/');
        #active user
        $user->update(['active' => '1']);
        #login
        Auth::login($user);
        #Success response
        return redirect('/')->with('success', trans('api.activeSuccess'));
        //return view('site.active');
    }

    #active post
    public function post_active(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'code' => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #get user
        $user = User::whereId($request->user_id)->first();
        #check code
        if ($user->code == $request->code) {
            #update client data
            $user->code = rand(111, 999);
            $user->active = '1';
            $user->save();

            #Success response
            return response()->json(['value' => 1, 'msg' => trans('api.activeSuccess')]);
        }

        #faild response
        return response()->json(['value' => 0, 'msg' => trans('api.wrongCode')]);
    }

    #login page
    public function login()
    {
        return view('site.login');
    }

    #login post
   public function post_login(Request $request)
{
    // Validate input (email/username required, password required)
    $validator = Validator::make($request->all(), [
        'login' => 'required', // Accepts email OR username
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Determine if the input is an email or username
    $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // Attempt login using email or username
    if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
        $user = Auth::user();

        // Update user's device if provided
        if (!is_null($request->device_id)) {
            update_device(Auth::user(), $request->device_id, 'web');
        }

        // Check if user is activated
        if ($user->active != '1') {
            $msg = Translate('قم بتفعيل حسابك');
            if ($request->ajax()) {
                return response()->json(['value' => 3, 'msg' => $msg]);
            }
            session()->put('danger', $msg);
        }

        // Check if user is blocked
        if ($user->blocked != '0') {
            $msg = Translate('قم بمراجعة حسابك مع الادارة');
            auth()->logout();
            if ($request->ajax()) {
                return response()->json(['value' => 2, 'msg' => $msg]);
            }
            session()->put('danger', $msg);
            return back();
        }

        // Update login status and timestamp
        $user->update(['login' => '1', 'login_date' => Carbon::now()]);

        // Success message and redirect
        session()->flash('success', Translate('تم تسجيل الدخول بنجاح'));
        return redirect('/');
    }

    // Failed login attempt
    session()->flash('danger', Translate('البيانات غير صحيحة قم بإعادة المحاولة'));
    return back();
}

    #register page
    public function register()
    {
        if (auth()->check())
            return redirect('/');

        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }


        $stepQuery = isset($queries['step']) && !empty($queries['step']) ? $queries['step'] : '1';
        $userQuery = isset($queries['user']) && !empty($queries['user']) ? $queries['user'] : 0;
        if (isset($userQuery) && !empty($userQuery))
        {
            $user = new User();
            $user->id = $userQuery;
        }

        return view('site.register', [
            'user' => isset($user) ? $user : null,
            'step' => isset($queries['step']) ? (int) $queries['step'] : '1',
        ]);
    }

    #register post
    public function post_register(Request $request)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }
        $stepQuery = isset($queries['step']) && !empty($queries['step']) ? $queries['step'] : '1';
        $userQuery = isset($queries['user']) && !empty($queries['user']) ? $queries['user'] : 0;
        if ($stepQuery == '2'){
            $validatedData = $request->validate([
                'desc_ar' => 'required|string|max:255',
                'goal_desc_ar' => 'required|string|max:255',
            ]);
            // Retrieve the existing data from the session
            $existingData = $request->session()->get('registration_data', []);

            // Ensure the existing data is an array
            if (!is_array($existingData)) {
                $existingData = (array)$existingData;
            }

            // Merge the second step data with existing session data
            $mergedData = array_merge($existingData, $validatedData);
            // convert the nested array in one single array
            $mergedData = makeNonNested($mergedData);
            // Store the merged data back into the session
            $request->session()->put('registration_data', $mergedData);

        }

        //dd($queries,$stepQuery,$userQuery);

        if (isset($userQuery) && !empty($userQuery)) {
            if ($stepQuery == '3') {
                $validator = $request->validate([
                    'username' => 'required|max:255|unique:users,username,' . (int) $userQuery,
                    'email' => 'required|max:255|email|unique:users,email,' . (int) $userQuery,
                    'password' => 'required|confirmed|min:6|max:255',
                ]);
            }
        } else {
            if ($stepQuery == '3') {
                $validator = $request->validate([
                    'username' => 'required|max:255|unique:users,username',
                    'email' => 'required|max:255|email|unique:users,email',
                    'password' => 'required|min:6|max:255',
                ]);
            }
        }

        #error response
        //if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);
        /*if ($validator->fails()){
            session()->flash('errors', $validator->errors());
            return back();
        }*/

        //if (isset($userQuery) && !empty($userQuery))
            //$user = User::whereId($userQuery)->first();
        #avatar
        if ($stepQuery === '1') {
            #avatar
            if ($request->hasFile('photo'))
                $avatar = $request->gender == 'female' ? '/public/female.png' : '/public/male.png';
                //$request->request->add(['avatar_edit' => upload_image($request->file('photo'), 'public/images/users'), 'edit_seen' => '0']);
            #city
            $avatar = $request->gender == 'female' ? '/public/female.png' : '/public/male.png';
            $city = City::whereId($request->city_id)->first();
            $request->request->add(['country_id' => isset($city) ? $city->country_id : null]);

            if ($request->has('goals'))
                $request->request->add(['goals' => implode(',', $request->goals)]);
            if ($request->has('communications'))
                $request->request->add(['communications' => implode(',', $request->communications)]);
            #update client
            //$user = User::whereId($userQuery)->first();
            //if ($request->has('password'))
            //    $user->update($request->except(['_token', 'photo', 'step', 'user', 'password_confirmation']));
            //else
            //    $user->update($request->except(['_token', 'device_id', 'photo', 'password', 'step', 'user', 'password_confirmation']));
            $request->request->add(['password' => '123456', 'user_type' => 'client', 'active' => 0, 'blocked' => 0, 'compelete' => 0, 'avatar' => $avatar, 'role_id' => Role::first()->id]);
            $request->session()->put('registration_data', $request->request);
        }
        //  else {
        //     if ($request->hasFile('photo'))
        //         $avatar = upload_image($request->file('photo'), 'public/images/users');
        //     else
        //         $avatar = $request->gender == 'female' ? '/public/female.png' : '/public/male.png';

        //     if ($request->has('goals'))
        //         $request->request->add(['goals' => implode(',', $request->goals)]);
        //     if ($request->has('communications'))
        //         $request->request->add(['communications' => implode(',', $request->communications)]);
        //     #store new client


        // }

        if (isset($stepQuery) && $stepQuery == '3') {
            $validatedData = $request->validate([
                'username' => 'required|max:255|unique:users,username',
                'email' => 'required|max:255|email|unique:users,email',
                'password' => 'required|min:6|max:255',
            ]);
            // Retrieve the existing data from the session
            $existingData = $request->session()->get('registration_data', []);

            // Ensure the existing data is an array
            if (!is_array($existingData)) {
                $existingData = (array)$existingData;
            }


            // Merge the final step data with existing session data
            $finalRegistrationData = array_merge($existingData, $validatedData);
            // convert the nested array in one single array
            $finalRegistrationData = makeNonNested($finalRegistrationData);
            $user = User::create(collect($finalRegistrationData)->except(['_token', 'device_id', 'step', 'user', 'password_confirmation', 'photo', 'device_id', 'password_confirmation', 'photos'])->toArray());
            #send mail to user
            /*$body  = "<p>مرحبًا " . $user->name . "</p>";
            $body .= "<p>نحن سعداء بانضمامك إلى زواج تبوك، المجتمع الذي يجمع بين الأشخاص لبناء علاقات جديدة واستكشاف فرص التعارف</p>";
            $body .= "<p>لقد قمت باتخاذ خطوة رائعة نحو لقاء أشخاص جدد وتوسيع دائرة معارفك. الآن، يمكنك البدء في تصفح الملفات الشخصية، مراسلة الأعضاء، وربما تجد الشخص الذي تبحث عنه!</p>";
            $body .= "<p>إليك بعض النصائح لتبدأ **</p>";
            $body .= "<p>تحديث ملفك الشخصي: أضف صورة شخصية مميزة وشارك القليل عن نفسك -</p>";
            $body .= "<p>كن نشطًا: استكشف الأعضاء الآخرين وابدأ محادثات جديدة -</p>";
            $body .= "<p>احترم الآخرين: حافظ على بيئة آمنة ومحترمة للجميع -</p>";
            $body .= "<p>نحن هنا لدعمك في كل خطوة إذا كان لديك أي استفسار أو تحتاج إلى مساعدة، لا تتردد في التواصل معنا -</p>";
            $body .= "<p>مع أطيب التحيات</p>";
            $body .= "<p>فريق زواج تبوك</p>";
            $msg   = "<html><head><title></title></head><body style='text-align: right'>" . $body . "</body></html>";
            //send_mail_html($user->email, $msg);*/

        //     $body = "<p>مرحبًا " . $user->name . "</p>";
        //     $body .= "<p>نحن سعداء بانضمامك إلى زواج تبوك، المجتمع الذي يجمع بين الأشخاص لبناء علاقات جديدة واستكشاف فرص التعارف.</p>";
        //     $body .= "<p>لقد قمت باتخاذ خطوة رائعة نحو لقاء أشخاص جدد وتوسيع دائرة معارفك. الآن، يمكنك البدء في تصفح الملفات الشخصية، مراسلة الأعضاء، وربما تجد الشخص الذي تبحث عنه!</p>";
        //     $body .= "<p>إليك بعض النصائح لتبدأ:</p>";
        //     $body .= "<ul>
        //     <li>تحديث ملفك الشخصي: أضف صورة شخصية مميزة وشارك القليل عن نفسك.</li>
        //     <li>كن نشطًا: استكشف الأعضاء الآخرين وابدأ محادثات جديدة.</li>
        //     <li>احترم الآخرين: حافظ على بيئة آمنة ومحترمة للجميع.</li>
        //   </ul>";
        //     $body .= "<p>نحن هنا لدعمك في كل خطوة. إذا كان لديك أي استفسار أو تحتاج إلى مساعدة، لا تتردد في التواصل معنا.</p>";

        //     $activationLink = url('site-active/' . $user->id);  // تعديل هذا ليناسب رابط التفعيل الخاص بك
        //     $buttonHTML = "<p style='text-align: center;'>
        //          <a href='$activationLink' style='
        //              background-color: #4CAF50;
        //              color: white;
        //              padding: 15px 20px;
        //              text-align: center;
        //              text-decoration: none;
        //              display: inline-block;
        //              font-size: 16px;
        //              border-radius: 5px;
        //          '>تفعيل الحساب</a>
        //        </p>";

        //     $body .= $buttonHTML;  // إضافة الزر بعد النص
        //     $body .= "<p>مع أطيب التحيات،</p>";
        //     $body .= "<p>فريق زواج تبوك</p>";

        //     $msg = "<html><head><title></title></head><body dir='rtl' style='text-align: right'>" . $body . "</body></html>";
            //send_mail_html($user->email, $msg);
            #login
            Auth::login($user);
            $header = "<p>يسرنا أن نرحب بك في موقع سعودي زواج،</p>";
            $header .= "<p>إنشاء الحساب هي أول خطوة في مشوار ايجاد شريكك المناسب</p>";
            $body= "<p>تم إنشاء الخطوات الأولي لحسابك أكمل الخطوة الأخيرة بتفعيل حسابك</p>";
            $body= "<p>لتتمكن من قراءة الرسايل واكتشاف الموقع</p>";
            $data = [
                'title' => 'أهلاً بك',
                'header' => $header,
                'body' => $body,
                'btn-text' => 'فعل حسابك',
                'url' => url('site-active/' . $user->id),
                'user' => $user,
                'password' => $finalRegistrationData['password'],
            ];
            $user->notify(new NewAccountNotification($data));
            #success response
            session()->flash('success', trans('api.save'));
            return redirect('/');
        }

        $nextStep = (int) $stepQuery + 1;
        //return redirect('register?step=' . $nextStep . '&user=' . $user->id);
        return redirect('register?step=' . $nextStep);
        //return redirect()->route('site_active');
    }

    #logout page
    public function logout()
    {
        $user = User::whereId(auth()->id())->first();
        if (isset($user))
            $user->update(['login' => '0', 'logout_date' => Carbon::now()]);

        #logout
        Auth::logout();
        return redirect('/');
    }

    #forget page
    public function forget_password()
    {
        return view('site.forget_password');
    }

    #forget post
    public function post_forget_password(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        if ($request->type == 'email') {
            $user = User::where('email', $request->email)->first();
            if (!isset($user)) {
                session()->flash('danger', Translate('بريد إلكتروني غير مسجل'));
                return back();
            }

            /** If Login Success But User's account has block **/
            if ($user->checked == '0') {
                session()->flash('danger', Translate('قم بمراجعة حسابك مع الإدارة'));
                return back();
            }

            #send code to client's phone
            $code = active_code();
            //send_mail_php($request->email, 'Verification code is : ' . $code);
           $data = [
    'title' => "أهلاً بك: {$user->name}",
'body' => "اسم المستخدم الخاص بك: {$user->username}\n",
    'code' => $code,
    'user' => $user->first_name
];

            Mail::to($user->email)->send(new VerificationCodeMailable($data));

            $msg = Translate('تم ارسال كود التحقق الى البريد الالكتروني');

        } else {
            $phoneCode = isset($request->phone_code) ? $request->phone_code : '966';
            $phone = convert_to_english($request->email);
            $user = User::wherePhone($phone)->wherePhoneCode($phoneCode)->first();
            if (!isset($user)) {
                session()->flash('danger', Translate('جوال غير مسجل'));
                return back();
            }

            /** If Login Success But User's account has block **/
            if ($user->checked == '0') {
                session()->flash('danger', Translate('قم بمراجعة حسابك مع الإدارة'));
                return back();
            }

            #send code to client's phone
            $code = active_code();
            $full_phone = convert_phone_to_international_format($phone, $phoneCode);
            sms_zain($full_phone, $code);

            $msg = Translate('تم ارسال كود التحقق الى جوالك');
        }

        $user->code = $code;
        $user->save();

        session()->flash('success', $msg);
        return redirect('reset-password/' . $user->id);
    }

    #reset page
    public function reset_password($id)
    {
        $user = User::whereId($id)->firstOrFail();
        return view('site.reset_password', ['user' => $user]);
    }

    #reset post
    public function post_reset_password(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'password' => 'required|min:6',
        ]);

        #check user
        $user = User::whereId($request->user_id)->firstOrFail();

        #wrong Code so back with msg
        if ($user->code != $request->code) {
            Session::flash('danger', Translate('كود غير صحيح'));
            return back();
        }

        #success code so reset new password
        $user->code = rand(111, 999);
        $user->password = $request->password;
        $user->save();

        Session::flash('success', Translate('تم تعديل كلمة المرور بنجاح'));
        return redirect()->route('site_login');
    }
}
