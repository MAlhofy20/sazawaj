<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_provider;
use App\Models\Order_time_static;
use App\Models\User_account;
use App\Models\Order_file;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class orderController extends Controller
{
    public function __construct()
    {
        // foreach(Order::whereNull('api_token')->get() as $order){
        //     $order->update(['api_token' => get_rand_code($order->id)]);
        // }

        checkIdCode();
        checkOrderTime();
    }
    
    

    #update
    public function update(Request $request)
    {
        if($request->has('created_at_date')
            &&
            $request->has('created_at_time')
            &&
            !empty($request->created_at_date)
            &&
            !empty($request->created_at_time)
        ) {
            $request->request->add(['created_at' => Carbon::parse($request->created_at_date . $request->created_at_time)]);
        }
        Order::whereId($request->id)->update($request->except(['_token', 'photo', 'created_at_date', 'created_at_time']));
        
        return back()->with('success', Translate('تم بنجاح'));
    }
    

    public function change_order_status(Request $request)
    {
        //check data
        $order = Order::whereId($request->id)->first();
        if (!isset($order)) return 0;
        //update data
        $order->data_upload = $order->data_upload == 1 ? 0 : 1;
        $order->save();

        //add report
        $order->data_upload ? admin_report(' تأكيد رفع الطلب بنجاح برقم: ' . $order->id) : admin_report('ألغاء تأكيد رفع الطلب برقم: ' . $order->id);
        $msg = $order->data_upload ? 'تم الرفع بنجاح' : 'في انتظار الرفع';
        return $msg;
    }

    #delete one
    public function delete(Request $request)
    {
        #get client
        $order = Order::whereId($request->id)->firstOrFail();
        $id = $order->id;

        #send FCM

        #delete client
        $order->delete();

        #add adminReport
        admin_report('حذف الطلب رقم: ' . $id);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #print_order
    public function print_order($id)
    {
        $order = Order::whereId($id)->firstOrFail();
        if(Auth::user()->user_type != 'admin') return view('site.orders.print', compact('order'));
        return view('dashboard.orders.print', compact('order'));
    }

    #index
    public function index($status)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        $booking_method = 'now';
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $booking_method = $queries['booking_method'];
        /** get cart Data **/
        $filter = '';
        $query = Order::query();
        // $query->where('provider_id', Auth::id());
        // $query->where('service_type', 'check');
        // $query->whereNull('order_id');
        // $query->where('type', $type);
        if($status != 'all') $query->where('status', $status);
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $query->where('booking_method', $queries['booking_method']);
        if (isset($queries['filter']) && !empty($queries['filter'])) {
            $filter = $queries['filter'];
            $start_date = Carbon::now();
            $end_date   = Carbon::now();
            if ($filter == 'week') {
                $start_date = Carbon::now()->startOfWeek();
                $end_date   = Carbon::now()->endOfWeek();
            }
            if ($filter == 'month') {
                $start_date = Carbon::now()->startOfMonth();
                $end_date   = Carbon::now()->endOfMonth();
            }
            if ($filter == 'year') {
                $start_date = Carbon::now()->startOfYear();
                $end_date   = Carbon::now()->endOfYear();
            }
            $query->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date);
        }
        $query->orderBy('id', 'desc');
        $data = $query->paginate(250);

        return view('dashboard.orders.index', compact('data', 'filter', 'status', 'queries', 'booking_method'));
    }

    #report
    public function report()
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        /** get cart Data **/
        $filter = '';
        $query = Order::query();
        $query->whereNull('order_id');
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['user']) && !empty($queries['user']))     $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))   $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status'])) $query->whereStatus($queries['status']);
        if (isset($queries['id_code']) && !empty($queries['id_code'])) $query->where('id_code', $queries['id_code']);
        if (isset($queries['type']) && !empty($queries['type']))     $query->where('type', $queries['type']);
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $query->where('booking_method', $queries['booking_method']);
        if (isset($queries['payment_method']) && !empty($queries['payment_method'])) $query->where('payment_method', $queries['payment_method']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('created_at', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('created_at', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $data = $query->get();

        $query = Order::query();
        $query->whereNull('order_id');
        $query->whereNotIn('status', ['refused', 'cancel']);
        $query->where('type', 'issuance');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['user']) && !empty($queries['user']))     $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))   $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status'])) $query->whereStatus($queries['status']);
        if (isset($queries['id_code']) && !empty($queries['id_code'])) $query->where('id_code', $queries['id_code']);
        if (isset($queries['type']) && !empty($queries['type']))     $query->where('type', $queries['type']);
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $query->where('booking_method', $queries['booking_method']);
        if (isset($queries['payment_method']) && !empty($queries['payment_method'])) $query->where('payment_method', $queries['payment_method']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('created_at', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('created_at', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $issuance_count = $query->count();

        $query = Order::query();
        $query->whereNull('order_id');
        $query->whereNotIn('status', ['refused', 'cancel']);
        $query->where('type', 'renewal');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['user']) && !empty($queries['user']))     $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))   $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status'])) $query->whereStatus($queries['status']);
        if (isset($queries['id_code']) && !empty($queries['id_code'])) $query->where('id_code', $queries['id_code']);
        if (isset($queries['type']) && !empty($queries['type']))     $query->where('type', $queries['type']);
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $query->where('booking_method', $queries['booking_method']);
        if (isset($queries['payment_method']) && !empty($queries['payment_method'])) $query->where('payment_method', $queries['payment_method']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('created_at', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('created_at', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $renewal_count = $query->count();

        $query = Order::query();
        $query->whereNull('order_id');
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['user']) && !empty($queries['user']))     $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))   $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status'])) $query->whereStatus($queries['status']);
        if (isset($queries['id_code']) && !empty($queries['id_code'])) $query->where('id_code', $queries['id_code']);
        if (isset($queries['type']) && !empty($queries['type']))     $query->where('type', $queries['type']);
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $query->where('booking_method', $queries['booking_method']);
        if (isset($queries['payment_method']) && !empty($queries['payment_method'])) $query->where('payment_method', $queries['payment_method']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('created_at', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('created_at', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $total = $query->sum('total_after_promo');

        $query = Order::query();
        $query->whereNull('order_id');
        $query->whereNotIn('status', ['refused', 'cancel']);
        $query->where('type', 'issuance');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['user']) && !empty($queries['user']))     $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))   $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status'])) $query->whereStatus($queries['status']);
        if (isset($queries['id_code']) && !empty($queries['id_code'])) $query->where('id_code', $queries['id_code']);
        if (isset($queries['type']) && !empty($queries['type']))     $query->where('type', $queries['type']);
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $query->where('booking_method', $queries['booking_method']);
        if (isset($queries['payment_method']) && !empty($queries['payment_method'])) $query->where('payment_method', $queries['payment_method']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('created_at', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('created_at', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $issuance = $query->sum('total_after_promo');

        $query = Order::query();
        $query->whereNull('order_id');
        $query->whereNotIn('status', ['refused', 'cancel']);
        $query->where('type', 'renewal');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['user']) && !empty($queries['user']))     $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))   $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status'])) $query->whereStatus($queries['status']);
        if (isset($queries['id_code']) && !empty($queries['id_code'])) $query->where('id_code', $queries['id_code']);
        if (isset($queries['type']) && !empty($queries['type']))     $query->where('type', $queries['type']);
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $query->where('booking_method', $queries['booking_method']);
        if (isset($queries['payment_method']) && !empty($queries['payment_method'])) $query->where('payment_method', $queries['payment_method']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('created_at', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('created_at', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $renewal = $query->sum('total_after_promo');
        
        /*$query = Order::query();
        $query->whereNull('order_id');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['market']) && !empty($queries['market']))         $query->whereProviderId($queries['market']);
        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $total = $query->sum('total_after_promo');
        
        $query = Order::query();
        $query->whereNull('order_id');
        $query->where('payment_method', 'cash');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['market']) && !empty($queries['market']))         $query->whereProviderId($queries['market']);
        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $cash_count = $query->count();
        
        $query = Order::query();
        $query->whereNull('order_id');
        $query->where('payment_method', 'cash');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['market']) && !empty($queries['market']))         $query->whereProviderId($queries['market']);
        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $cash = $query->sum('total_after_promo');
        
        $query = Order::query();
        $query->whereNull('order_id');
        $query->where('payment_method', 'online');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['market']) && !empty($queries['market']))         $query->whereProviderId($queries['market']);
        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $online_count = $query->count();
        
        $query = Order::query();
        $query->whereNull('order_id');
        $query->where('payment_method', 'online');
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
        if (isset($queries['market']) && !empty($queries['market']))         $query->whereProviderId($queries['market']);
        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
        $query->orderBy('id', 'desc');
        $online = $query->sum('total_after_promo');*/

        return view('dashboard.orders.report', compact('data' , 'queries', 'issuance_count', 'renewal_count', 'total', 'issuance', 'renewal'));
    }

    #show
    public function show($id)
    {
        $order = Order_file::whereId($id)->firstOrFail();
        return view('dashboard.orders.show', compact('order'));
    }

    #change
    public function change_provider(Request $request)
    {
        $order      = Order::whereId($request->id)->first();
        $provider   = User::whereId($request->provider_id)->first();
        if (isset($provider)) {
            $order->update([
                'status'         => 'current',
                'provider_id'    => $provider->id,
                'provider_name'  => $provider->name,
                'provider_phone' => $provider->phone,
            ]);

            #sent notify to provider
            $lang = $provider->lang == 'en' ? 'en' : 'ar';
            $msg  = [
                'title_ar'    => 'لديك طلب جديد برقم :' . $order->id,
                'title_en'    => 'You have a new Order No : ' . $order->id,
            ];
            $message = $msg['title_' . $lang];
            send_notify($provider->id, $msg['title_ar'], $msg['title_en'], $order->id, $order->status);
            foreach ($provider->devices as $device) {
                $device_id   = $device->device_id;
                if (!is_null($device_id)) send_one_signal($message, $device_id, '', $provider->user_type, $order->id);
            }
        }

        return back()->with('success', Translate('تم بنجاح'));
    }

    #change
    public function change_providers(Request $request)
    {
        #get promo_codes
        $ids         = $request->ids;
        $first_ids   = ltrim($ids, ',');
        $second_ids  = rtrim($first_ids, ',');
        $order_ids   = explode(',', $second_ids);
        $orders = Order::whereIn('id', $order_ids)->get();
        foreach ($orders as $order) {
            $provider   = User::whereId($request->provider_id)->first();
            if (isset($provider)) {
                $order->update([
                    'status'         => 'current',
                    'provider_id'    => $provider->id,
                    'provider_name'  => $provider->name,
                    'provider_phone' => $provider->phone,
                ]);

                #sent notify to provider
                $lang = $provider->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'لديك طلب جديد برقم :' . $order->id,
                    'title_en'    => 'You have a new Order No : ' . $order->id,
                ];
                $message = $msg['title_' . $lang];
                send_notify($provider->id, $msg['title_ar'], $msg['title_en'], $order->id, $order->status);
                foreach ($provider->devices as $device) {
                    $device_id   = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $provider->user_type, $order->id);
                }
            }
        }

        return back()->with('success', Translate('تم بنجاح'));
    }

    #change
    public function change(Request $request)
    {
        #data
        $id          = $request->has('order_id') ? $request->order_id : $request->id;
        $status      = $request->status;
        $order       = Order::whereId($id)->firstOrFail();
        $user        = $order->user;
        if($request->has('delegate_id')) $provider = User::whereId($request->delegate_id)->first();

        $order->update(['status' => $status,'status_date' => date('Y-m-d'),'status_user_name' => auth()->user()->name, 'delegate_id' => isset($provider) ? $provider->id : $order->delegate_id]);

        if ($status == 'refused') {
            Order_time_static::where('order_id', $order->id)->delete();

            #sent notify to user
            if (isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg = [
                    'title_ar' => 'عزيزي العميل تم رفض حجزك برقم :' . $order->id,
                    'title_en' => 'Your Order No : ' . $order->id . ' is refused',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'in_way');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }
        } elseif ($status == 'in_way') { //in way order
            #sent notify to user
            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg = [
                    'title_ar' => 'عزيزي العميل جاري تنفيذ طلبك برقم :' . $order->id,
                    'title_en' => 'Your Order No : ' . $order->id . ' in being processed',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'in_way');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }

            /*if(isset($provider)) {
                #sent notify to provider
                $lang = $provider->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'لديك طلب جديد برقم :' . $order->id,
                    'title_en'    => 'You have a current Order No : ' . $order->id,
                ];
                $message = $msg['title_' . $lang];
                send_notify($provider->id, $msg['title_ar'], $msg['title_en'], $order->id, 'in_way');
                foreach ($provider->devices as $device) {
                    $device_id   = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $provider->user_type, $order->id);
                }
            }*/

        } elseif ($status == 'current') { //current order
            if (isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم تأكيد حجزك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is accepted',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'current');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }

        } elseif ($status == 'finish') { //finish order
            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم الانتهاء من الحجز برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is finished',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'finish');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }
        } elseif ($status == 'refused') { //refused order
            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عملائنا الكرام ، نعتذر لكم عن عدم خدمتكم ، الخدمة قيد الإنشاء في منطقتك حالياً للحجز برقم :' . $order->id,
                    'title_en'    => 'Dear customers, we apologize for not serving you, the service is currently under construction in your area to book with a number : ' . $order->id,
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'refused');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }
        }

        #add adminReport
        // admin_report('تغيير حالة الطلب رقم : ' . $id);
        return back()->with('success', Translate('تم بنجاح'));
    }
}
