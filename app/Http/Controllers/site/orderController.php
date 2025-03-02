<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Order_provider;
use App\Models\Order_time_static;
use App\Models\Section;
use App\Models\User_gift;
use App\Models\User_account;
use App\Models\Order_file;
use App\Models\Promo_code;
use App\Models\User;
use Auth;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class orderController extends Controller
{
    public function __construct()
    {
        // foreach (Order::whereNull('api_token')->get() as $order) {
        //     $order->update(['api_token' => get_rand_code($order->id)]);
        // }

        checkOrderTime();
    }
    
    #index
    public function index($status, $id)
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        $booking_method = 'now';
        if (isset($queries['booking_method']) && !empty($queries['booking_method'])) $booking_method = $queries['booking_method'];
        /** get cart Data **/
        $provider_id = auth()->user()->user_type == 'provider' ? auth()->id() : auth()->user()->provider_id;
        $filter = '';
        $query = Order::query();
        $query->where('provider_id', $provider_id);
        $query->whereNull('order_id');
        // $query->where('service_type', 'check');
        $query->where('status', $status);
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

        return view('site.orders.index', compact('data', 'filter' , 'status', 'id', 'queries', 'booking_method'));
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
        $provider_id = auth()->user()->user_type == 'provider' ? auth()->id() : auth()->user()->provider_id;
        $filter = '';
        $query = Order::query();
        $query->whereProviderId($provider_id);
        $query->whereNull('order_id');
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
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
        $query->whereProviderId($provider_id);
        $query->where('type', 'issuance');
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
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
        $query->whereProviderId($provider_id);
        $query->where('type', 'renewal');
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
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
        $query->whereProviderId($provider_id);
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
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
        $query->whereProviderId($provider_id);
        $query->where('type', 'issuance');
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
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
        $query->whereProviderId($provider_id);
        $query->where('type', 'renewal');
        $query->whereNotIn('status', ['refused', 'cancel']);
        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
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

        return view('site.orders.report', compact('data', 'queries', 'filter', 'issuance_count', 'renewal_count', 'total', 'issuance', 'renewal'));
    }

    #report
//    public function report($id)
//    {
//        #query string
//        $queries = [];
//        if(isset( $_SERVER['QUERY_STRING'])){
//            parse_str($_SERVER['QUERY_STRING'], $queries);
//        }
//
//        /** get cart Data **/
//        $filter = '';
//        $query = Order::query();
//        $query->whereNull('order_id');
//        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
//        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
//        $query->whereProviderId($id);
//        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
//        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
//        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
//        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
//        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
//        $query->orderBy('id', 'desc');
//        $data = $query->get();
//
//        $query = Order::query();
//        $query->whereNull('order_id');
//        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
//        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
//        $query->whereProviderId(auth()->id());
//        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
//        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
//        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
//        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
//        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
//        $query->orderBy('id', 'desc');
//        $total = $query->sum('total_after_promo');
//
//        $query = Order::query();
//        $query->whereNull('order_id');
//        $query->where('payment_method', 'cash');
//        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
//        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
//        $query->whereProviderId(auth()->id());
//        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
//        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
//        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
//        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
//        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
//        $query->orderBy('id', 'desc');
//        $cash_count = $query->count();
//
//        $query = Order::query();
//        $query->whereNull('order_id');
//        $query->where('payment_method', 'cash');
//        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
//        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
//        $query->whereProviderId(auth()->id());
//        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
//        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
//        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
//        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
//        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
//        $query->orderBy('id', 'desc');
//        $cash = $query->sum('total_after_promo');
//
//        $query = Order::query();
//        $query->whereNull('order_id');
//        $query->where('payment_method', 'online');
//        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
//        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
//        $query->whereProviderId(auth()->id());
//        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
//        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
//        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
//        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
//        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
//        $query->orderBy('id', 'desc');
//        $online_count = $query->count();
//
//        $query = Order::query();
//        $query->whereNull('order_id');
//        $query->where('payment_method', 'online');
//        // if (isset($queries['city']) && !empty($queries['city']))             $query->whereCityId($queries['city']);
//        // if (isset($queries['provider']) && !empty($queries['provider']))     $query->whereProviderId($queries['provider']);
//        $query->whereProviderId(auth()->id());
//        if (isset($queries['user']) && !empty($queries['user']))             $query->whereUserId($queries['user']);
//        if (isset($queries['phone']) && !empty($queries['phone']))           $query->whereUserPhone($queries['phone']);
//        if (isset($queries['status']) && !empty($queries['status']))         $query->whereStatus($queries['status']);
//        if (isset($queries['start_date']) && !empty($queries['start_date'])) $query->whereDate('date', '>=', $queries['start_date']);
//        if (isset($queries['end_date']) && !empty($queries['end_date']))     $query->whereDate('date', '<=', $queries['end_date']);
//        $query->orderBy('id', 'desc');
//        $online = $query->sum('total_after_promo');
//
//        return view('site.orders.report', compact('data', 'queries', 'total', 'cash', 'cash_count', 'online', 'online_count'));
//    }

    #print_order
    public function print_order($id)
    {
        $order = Order::whereId($id)->firstOrFail();
        if(Auth::user()->user_type != 'admin') return view('site.orders.print', compact('order'));
        return view('site.orders.print', compact('order'));
    }

    #index
    public function site_orders()
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }

        /** get cart Data **/
        $filter = '';
        $query = Order::query();
        if (isset($queries['site']) && !empty($queries['site'])) {
            $query->where('user_id', $queries['site']);
        }else{
            $query->whereHas('user', function($q){
                return $q->where('supervisor_id' , Auth::id());
            });
        }
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
        $data = $query->get();

        $cities = City::orderBy('country_id')->get();

        return view('site.orders.site_orders', compact('data', 'filter' , 'cities'));
    }

    #show
    public function show($id)
    {
        $order = Order_file::whereId($id)->firstOrFail();
        return view('site.orders.show', compact('order'));
    }

    public function static_show($id)
    {
        $order = Order_file::whereId($id)->firstOrFail();
        return view('show_order', compact('order'));
    }

    #update
    public function update(Request $request)
    {
        $request->request->add([
            'total_before_promo' => $request->total_after_promo,
            'total_after_promo'  => $request->total_after_promo,
        ]);
        Order::whereId($request->id)->update($request->except(['_token', 'photo']));
        
        return back()->with('success', Translate('تم بنجاح'));
    }
    
    #agree
    public function agree(Request $request)
    {
        $user = User::whereId($request->provider_id)->first();
        Order::whereId($request->id)->update([
            'status'        => 'current',   'provider_id'    => $request->provider_id,
            'provider_name' => $user->name, 'provider_phone' => $user->phone,   'provider_email' => $user->email,
        ]);
        #add adminReport
        ////('تعيين الموظف ' . $user->name . ' للطلب رقم : ' . $request->id);
        return back()->with('success', Translate('تم بنجاح'));
    }

    public function site_add_order_report(Request $request)
    {
        if ($request->hasFile('photo')) $request->request->add(['file' => upload_image($request->file('photo'), 'public/images/sections')]);
        Order_file::create($request->except(['_token', 'photo']));
        #add adminReport
        return back()->with('success', Translate('تم بنجاح'));
    }

    public function site_update_order_report(Request $request)
    {
        if ($request->hasFile('photo')) $request->request->add(['file' => upload_image($request->file('photo'), 'public/images/sections')]);
        Order_file::whereId($request->id)->update($request->except(['_token', 'photo']));
        #add adminReport
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
        $discount_percent   = $request->has('discount_percent') ? (float) $request->discount_percent : 0;
        $total_before_promo = (float) $order->total_before_promo;
        $discount           = $discount_percent > 0 ? $total_before_promo * $discount_percent / 100 : 0;
        $total_after_promo  = $total_before_promo - $discount;
        if($request->has('delegate_id')) $provider = User::whereId($request->delegate_id)->first();

        $order->update([
            'status'             => $status,
            'total_before_promo' => $total_before_promo,
            'total_after_promo'  => $total_after_promo,
            'delegate_id'        => isset($provider) ? $provider->id : $order->delegate_id
        ]);

        if($status == 'refused') {
            //Order_time_static::where('order_id', $order->id)->delete();

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
        } 
        elseif ($status == 'in_way') { //in way order
            #sent notify to user
            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg = [
                    'title_ar' => 'عزيزي العميل تم تجهيز حجزك برقم :' . $order->id,
                    'title_en' => 'Your Order No : ' . $order->id . ' in way',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'in_way');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }

            if(isset($provider)) {
                #sent notify to provider
                $lang = $provider->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'لديك حجز جديد برقم :' . $order->id,
                    'title_en'    => 'You have a current Order No : ' . $order->id,
                ];
                $message = $msg['title_' . $lang];
                send_notify($provider->id, $msg['title_ar'], $msg['title_en'], $order->id, 'in_way');
                foreach ($provider->devices as $device) {
                    $device_id   = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $provider->user_type, $order->id);
                }
            }

        } 
        elseif ($status == 'current') { //current order
            if(isset($user)) {
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
                    'title_ar'    => 'عزيزي العميل تم تسليم حجزك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is finished',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'finish');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }
        }

        #add adminReport
        // //('تغيير حالة الحجز رقم : ' . $id);
        return back()->with('success', Translate('تم بنجاح'));
    }

    #addData
    public function addData(Request $request)
    {
        $order = Order::whereId($request->id)->first();
        $data  = is_null($order->data) ? [] : json_decode($order->data);
        $index = count($data);
        $title = $request->title;
        $desc  = $request->desc;
        foreach ($title as $key => $value) {
            if (!is_null($value) && !is_null($desc[$key])) {
                $data[$index]['title'] = $value;
                $data[$index]['desc']  = $desc[$key];
                $index++;
            }
        }
        $order->update(['data' => json_encode($data)]);
        #add adminReport
        //admin_report('أضافة البيانات للحجز رقم : ' . $request->id);
        return back()->with('success', Translate('تم الاضافة بنجاح'));
    }

    #addDepartmentData
    public function addDepartmentData($id)
    {
        Order::whereId($id)->update(['status' => 'in_way']);
        return back()->with('success', Translate('الحجز في الطريق الان'));
    }

    public function new_order($id)
    {
        $provider = User::whereId($id)->firstOrFail();
        return view('show_service', compact('id', 'provider'));
    }

    #store
    public function store_order(Request $request)
    {
        /** Validate Request **/
        $validate = $request->validate([
            'name'           => 'required|max:191',
            'phone'          => 'required|min:9|max:9|regex:/^[5]\d*$/',
            'id_number'      => 'required|min:10|max:10|regex:/^[12]\d*$/',
            'day'            => 'required',
            'month'          => 'required',
            'year'           => 'required',
            //'birthdate'      => 'required',
            //'photo'          => 'required',
            'payment_method' => 'required',
        ]);

        #Promo data
        $promo_id = null;
        $discount = 0;
        if (!empty($request->promo_code)) {
            $promo    = Promo_code::where('code', $request->promo_code)->first();
            $promo_id = isset($promo) ? $promo->id : null;
            $discount = isset($promo) ? $promo->discount : 0;
        }

        #store order
        $total_before_promo = $request->total_before_promo;
        $discount           = $total_before_promo * $discount / 100;
        $total_after_promo  = $total_before_promo - $discount;

        if ($request->hasFile('photo')) $request->request->add(['file' => upload_image($request->file('photo'), 'public/images/sections')]);
        $request->request->add([
            'status'             => 'new',
            'birthdate'          => Carbon::parse($request->year.'-'.$request->month.'-'.$request->day)->format('Y-m-d'),
            'promo_id'           => $promo_id,
            'total_after_promo'  => $total_after_promo,
            'phone'              => convert_to_english($request->phone),
        ]);
        $order = Order::create($request->except(['_token', 'photo', 'day', 'month', 'year']));

        /** Send Success Massage **/
        //session()->flash('success', Translate('تم الارسال بنجاح'));
        return redirect('thanks');
        //return redirect('my_order/'.$order->id);
    }

    #edit
    public function edit_order($id){
        $order = Order::whereId($id)->first();
        if(!isset($order)){ return route('site_name'); }

        $data = [
            'cart'          => Order_item::where('order_id' , $id)->get(),
            'total'         => Order_item::where('order_id' , $id)->sum('total'),
            'cities'        => City::get(),
            'order'         => $order,
            'commission'    => userCommission(Auth::id()),
            'variable_rate' => (float) settings('variable_rate')
        ];
        return view('site.edit_order' , $data);
    }

    #update cart
    public function update_order(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'order_id'      => 'required|exists:orders,id',
            'order_item_id' => 'required|exists:order_items,id',
            'count'         => 'required',
            'total'         => 'required',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return response()->json(['key' => 'fail', 'value' => 0, 'msg' => $validate->errors()->first()]);

        /** update order **/
        $add      = Order::whereId($request->order_id)->firstOrFail();
        $user     = $add->User;
        $order_item     = Order_item::whereId($request->order_item_id)->first();
        $section = Section::whereId($order_item->section_id)->first();
        if ($section->quantity < $request->count)
            return response()->json(['key' => 'fail', 'value' => 0, 'msg' => trans('api.noQuantity'), 'count' => $order_item->count, 'total' => $order_item->total, 'total_cart' => Order_item::where('order_id', $request->order_id)->sum('total')]);

        if ($request->count <= 0) {
            $order_item->delete();
            if($add->Items->count() == 0) $add->delete();
            return response()->json(['key' => 'success', 'value' => 2, 'total_cart' => Order_item::where('order_id', $request->order_id)->sum('total')]);
        }

        $order_item->count = $request->count;
        $order_item->total = $request->total;
        $order_item->save();

        // data
        $benfit_type       = $user->benfit_type; //user benfit
        $commission        = 0; // commision for 1 item
        $point             = 0; // points for 1 item
        $commissions       = 0; // calculate commision
        $points            = 0; // calculate point
        $benifts           = 0; //user order's benfits

        #total variables
        $commissions              = 0; // total site commissions
        $supervisor_commissions   = 0; // total supervisor site commissions
        $over_prices              = 0; // total over_price

        #order items
        foreach ($add->Items as $item) {
            #get section
            $section = Section::whereId($item->section_id)->first();
            #check quantity
            if ($section->quantity >= $item->count && $item->count > 0) { //if have product quantity
                #get order site
                $user = User::whereId($add->user_id)->first();
                #check user type
                if($user->user_type == 'site'){ // if user type is site
                    $supervisor = User::whereId($user->supervisor_id)->first();
                    #calc commission
                    $all_bouns        = 0; // Bouns
                    $site_bouns   = isset($user) ? floatval($user->bouns) : 0; // Bouns
                    $supervisor_bouns = isset($supervisor) ? floatval($supervisor->bouns) : 0; // Bouns
                    // site commission
                    $commission   = $add->delivery_type == 'delegate' ? // check if order has delegate or shiping
                                    $section->site_delegate_commission + $site_bouns //has delegate
                                    :
                                    $section->site_shiping_commission + $site_bouns; // has shiping
                    // supervisor site commission
                    $commission_supervisor = $add->delivery_type == 'delegate' ?  // check if order has delegate or shiping
                                            ($section->supervisor_delegate_commission + $supervisor_bouns) - ($section->site_delegate_commission + $site_bouns) //has delegate
                                            :
                                            ($section->supervisor_shiping_commission + $supervisor_bouns) - ($section->site_shiping_commission + $site_bouns); // has shiping
                    #this item
                    $real_total            = $item->count * get_price($section , $item->count);     // real total
                    $over_price            = $item->total - $real_total;             // over price
                    $product_commission    = $item->count * $commission;             // site commissions
                    $supervisor_commission = $item->count * $commission_supervisor;  // supervisor site commissions
                    #total
                    $commissions            += $product_commission;     // total site commissions
                    $supervisor_commissions += $supervisor_commission;  // total supervisor site commissions
                    $over_prices            += $over_price;             // total over_price

                }else{ // if user type is supervisor site
                    #calc commission
                    $bouns       = isset($user) ? floatval($user->bouns) : 0; // Bouns
                    $commission  = 0; // site commission
                    // supervisor site commission
                    $commission_supervisor    = $add->delivery_type == 'delegate' ? // check if order has delegate or shiping
                                                $section->supervisor_delegate_commission + $bouns  //has delegate
                                                :
                                                $section->supervisor_shiping_commission + $bouns; // has shiping
                    #this item
                    $real_total            = $item->count * get_price($section , $item->count);     // real total
                    $over_price            = $item->total - $real_total;             // over price
                    $product_commission    = $item->count * $commission;             // site commissions
                    $supervisor_commission = $item->count * $commission_supervisor;  // supervisor site commissions
                    #total
                    $commissions            += $product_commission;     // total site commissions
                    $supervisor_commissions += $supervisor_commission;  // total supervisor site commissions
                    $over_prices            += $over_price;             // total over_price
                }

                $count_after_gift   = $item->count; //buy item count
                $using_gift_count   = 0; //gift item count

                $buy_total          = $count_after_gift * $section->buy_price; //Product Purchasing price
                $gift_total         = $using_gift_count * $section->gift_price; //Product gift price
                $buy_total          = $buy_total + $gift_total; //Total Product Purchasing price
                $product_point      = $item->count * $point; // Product points
                $product_benfit     = $item->total - $buy_total; // Product benfits
                $benifts            = $benifts + $product_benfit; // add to total cart item benfits

                //store order item
                $item->buy_total             = $buy_total;              //Purchasing price
                $item->gift_total            = $gift_total;
                $item->gift_count            = $using_gift_count;
                $item->commission            = $product_commission;
                $item->supervisor_commission = $supervisor_commission;
                $item->over_price            = $over_price;
                $item->point                 = $product_point;
                $item->benfit                = $product_benfit;
                $item->save();

                $section->quantity  = $section->quantity - $item->count;
                $section->save();
            } else { //if have not product quantity
                // delete order
                $item->delete();
                // return response()->json(['key' => 'fail', 'value' => 0, 'msg' => trans('api.qyentityTaken')]);
            }
        }

        // update order data
        $add->site_benfit        = $benifts;
        $add->site_commission    = $commissions;
        $add->supervisor_commission  = $supervisor_commissions;
        $add->over_price             = $over_prices;
        $add->site_point         = $points;
        $add->save();

        /** Send Success Massage **/
        return response()->json(['key' => 'success', 'value' => 1, 'msg' => trans('api.saveToCart'), 'count' => $add->count, 'total' => $add->total, 'total_cart' => Order_item::where('order_id', $request->order_id)->sum('total')]);
    }

    #update cart
    public function updatedata_order(Request $request)
    {
        // Validation rules
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'city_id'  => 'required|exists:cities,id',
            'name'     => 'required',
            'phone'    => 'required',
            'whatsapp' => 'nullable',
            'email'    => 'nullable',
            'lat'      => 'nullable',
            'lng'      => 'nullable',
            'address'  => 'required',
            'date'     => 'nullable',
            'time'     => 'nullable',
        ];

        // Validation
        $validator = Validator::make($request->all(), $rules);
        // If failed
        if ($validator->fails()) return back()->withErrors($validator);

        /** update order **/
        $city    = City::whereId($request->city_id)->first();
        $country = Country::whereId($city->country_id)->first();
        $code    = $country->code;
        $phone   = convert_phone_to_international_format($code, $request->phone);

        //check phone if in used in another order
        $start = Carbon::now()->subDays(2);
        $end   = Carbon::now();
        $order = Order::where('id' , '!=' ,$request->order_id)->wherePhone($phone)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->first();
        if(isset($order)) return back()->with('danger' , trans('api.notAllowedOrder'));

        // send order to providers in the same city
        $providers = User::where('user_type', 'delegate')
            ->where('city_id', $request->city_id)
            ->where('checked', '1')
            // ->where('confirm', '1')
            ->where('activation', '1')
            ->pluck('id')->toArray();

        $add      = Order::whereId($request->order_id)->firstOrFail();
        $add->name          = $request->name;
        $add->phone         = convert_phone_to_international_format($code, $request->phone);
        $add->whatsapp      = empty($request->whatsapp) ? convert_phone_to_international_format($code, $request->phone) : convert_phone_to_international_format($code, $request->whatsapp);
        $add->email         = $request->email;
        $add->country_id    = $country->id;
        $add->city_id       = $request->city_id;
        $add->lat           = $request->lat;
        $add->lng           = $request->lng;
        $add->comment       = $request->comment;
        $add->address       = $request->address;
        $add->date          = is_null($request->date) ? Carbon::now()->format('Y-m-d H:i:s') : Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $add->time          = $request->time;
        $add->delivery_type = count($providers) > 0 ? 'delegate' : 'company';
        $add->save();

        $user     = $add->User;

        // data
        $benfit_type       = $user->benfit_type; //user benfit
        $commission        = 0; // commision for 1 item
        $point             = 0; // points for 1 item
        $commissions       = 0; // calculate commision
        $points            = 0; // calculate point
        $benifts           = 0; //user order's benfits

        #total variables
        $commissions              = 0; // total site commissions
        $supervisor_commissions   = 0; // total supervisor site commissions
        $over_prices              = 0; // total over_price

        #order items
        foreach ($add->Items as $item) {
            #get section
            $section = Section::whereId($item->section_id)->first();
            #check quantity
            if ($section->quantity >= $item->count && $item->count > 0) { //if have product quantity
                #get order site
                $user = User::whereId($add->user_id)->first();
                #check user type
                if($user->user_type == 'site'){ // if user type is site
                    $supervisor = User::whereId($user->supervisor_id)->first();
                    #calc commission
                    $all_bouns        = 0; // Bouns
                    $site_bouns   = isset($user) ? floatval($user->bouns) : 0; // Bouns
                    $supervisor_bouns = isset($supervisor) ? floatval($supervisor->bouns) : 0; // Bouns
                    // site commission
                    $commission   = $add->delivery_type == 'delegate' ? // check if order has delegate or shiping
                                    $section->site_delegate_commission + $site_bouns //has delegate
                                    :
                                    $section->site_shiping_commission + $site_bouns; // has shiping
                    // supervisor site commission
                    $commission_supervisor = $add->delivery_type == 'delegate' ?  // check if order has delegate or shiping
                                            ($section->supervisor_delegate_commission + $supervisor_bouns) - ($section->site_delegate_commission + $site_bouns) //has delegate
                                            :
                                            ($section->supervisor_shiping_commission + $supervisor_bouns) - ($section->site_shiping_commission + $site_bouns); // has shiping
                    #this item
                    $real_total            = $item->count * get_price($section , $item->count);     // real total
                    $over_price            = $item->total - $real_total;             // over price
                    $product_commission    = $item->count * $commission;             // site commissions
                    $supervisor_commission = $item->count * $commission_supervisor;  // supervisor site commissions
                    #total
                    $commissions            += $product_commission;     // total site commissions
                    $supervisor_commissions += $supervisor_commission;  // total supervisor site commissions
                    $over_prices            += $over_price;             // total over_price

                }else{ // if user type is supervisor site
                    #calc commission
                    $bouns       = isset($user) ? floatval($user->bouns) : 0; // Bouns
                    $commission  = 0; // site commission
                    // supervisor site commission
                    $commission_supervisor    = $add->delivery_type == 'delegate' ? // check if order has delegate or shiping
                                                $section->supervisor_delegate_commission + $bouns  //has delegate
                                                :
                                                $section->supervisor_shiping_commission + $bouns; // has shiping
                    #this item
                    $real_total            = $item->count * get_price($section , $item->count);     // real total
                    $over_price            = $item->total - $real_total;             // over price
                    $product_commission    = $item->count * $commission;             // site commissions
                    $supervisor_commission = $item->count * $commission_supervisor;  // supervisor site commissions
                    #total
                    $commissions            += $product_commission;     // total site commissions
                    $supervisor_commissions += $supervisor_commission;  // total supervisor site commissions
                    $over_prices            += $over_price;             // total over_price
                }

                $count_after_gift   = $item->count; //buy item count
                $using_gift_count   = 0; //gift item count

                $buy_total          = $count_after_gift * $section->buy_price; //Product Purchasing price
                $gift_total         = $using_gift_count * $section->gift_price; //Product gift price
                $buy_total          = $buy_total + $gift_total; //Total Product Purchasing price
                $product_point      = $item->count * $point; // Product points
                $product_benfit     = $item->total - $buy_total; // Product benfits
                $benifts            = $benifts + $product_benfit; // add to total cart item benfits

                //store order item
                $item->buy_total             = $buy_total;              //Purchasing price
                $item->gift_total            = $gift_total;
                $item->gift_count            = $using_gift_count;
                $item->commission            = $product_commission;
                $item->supervisor_commission = $supervisor_commission;
                $item->over_price            = $over_price;
                $item->point                 = $product_point;
                $item->benfit                = $product_benfit;
                $item->save();

                $section->quantity  = $section->quantity - $item->count;
                $section->save();
            } else { //if have not product quantity
                // delete order
                $item->delete();
                return back()->with('danger' , trans('api.qyentityTaken'));
                // return response()->json(['key' => 'fail', 'value' => 0, 'msg' => trans('api.qyentityTaken')]);
            }
        }

        // update order data
        $add->site_benfit        = $benifts;
        $add->site_commission    = $commissions;
        $add->supervisor_commission  = $supervisor_commissions;
        $add->over_price             = $over_prices;
        $add->site_point         = $points;
        $add->save();

        /** Send Success Massage **/
        return back()->with('success' , trans('api.save'));
    }

    #store
    // public function update_order(Request $request)
    // {
    //     /** Validate Request **/
    //     $validate = Validator::make($request->all(), [
    //         'order_id'          => 'required|exists:orders,id',
    //     ]);

    //     /** Send Error Massages **/
    //     if ($validate->fails())
    //         return response()->json(['key' => 'fail', 'value' => 0, 'msg' => $validate->errors()->first()]);

    //     // Data
    //     $user           = User::whereId(Auth::id())->first();
    //     //check cart
    //     if ($cart_count == 0) return response()->json(['key' => 'fail', 'value' => 0, 'msg' => trans('api.emptyCart')]);

    //     $order = Order::whereId($id)->firstOrFail();

    //     // data
    //     $carts             = Cart::where('user_id', Auth::id())->get(); // get cart items
    //     $cart_item_count   = Cart::where('user_id', Auth::id())->sum('count'); // cart items count
    //     $benfit_type       = $user->benfit_type; //user benfit
    //     $commission        = $benfit_type == 'commission_point' ? 0 : (float) settings('full_commission'); // commision for 1 item
    //     $point             = $benfit_type == 'commission_point' ? (float) settings('point') : 0; // points for 1 item
    //     $commissions       = $cart_item_count * $commission; // calculate commision
    //     $points            = $cart_item_count * $point; // calculate point
    //     $benifts           = 0; //user order's benfits

    //     if(is_null($benfit_type)){
    //         #total variables
    //         $commissions              = 0; // total site commissions
    //         $supervisor_commissions   = 0; // total supervisor site commissions
    //         $over_prices              = 0; // total over_price

    //         #order items
    //         foreach ($carts as $item) {
    //             #get section
    //             $section = Section::whereId($item->section_id)->first();
    //             #check quantity
    //             if ($section->quantity >= $item->count && $item->count > 0) { //if have product quantity
    //                 #get order site
    //                 $user = User::whereId($add->user_id)->first();
    //                 #check user type
    //                 if($user->user_type == 'site'){ // if user type is site
    //                     $supervisor = User::whereId($user->supervisor_id)->first();
    //                     #calc commission
    //                     $all_bouns        = 0; // Bouns
    //                     $site_bouns   = isset($user) ? floatval($user->bouns) : 0; // Bouns
    //                     $supervisor_bouns = isset($supervisor) ? floatval($supervisor->bouns) : 0; // Bouns
    //                     // site commission
    //                     $commission   = count($providers) > 0 ? // check if order has delegate or shiping
    //                                     $section->site_delegate_commission + $site_bouns //has delegate
    //                                     :
    //                                     $section->site_shiping_commission + $site_bouns; // has shiping
    //                     // supervisor site commission
    //                     $commission_supervisor = count($providers) > 0 ?  // check if order has delegate or shiping
    //                                             ($section->supervisor_delegate_commission + $supervisor_bouns) - ($section->site_delegate_commission + $site_bouns) //has delegate
    //                                             :
    //                                             ($section->supervisor_shiping_commission + $supervisor_bouns) - ($section->site_shiping_commission + $site_bouns); // has shiping
    //                     #this item
    //                     $real_total            = $item->count * get_price($section , $item->count);     // real total
    //                     $over_price            = $item->total - $real_total;             // over price
    //                     $product_commission    = $item->count * $commission;             // site commissions
    //                     $supervisor_commission = $item->count * $commission_supervisor;  // supervisor site commissions
    //                     #total
    //                     $commissions            += $product_commission;     // total site commissions
    //                     $supervisor_commissions += $supervisor_commission;  // total supervisor site commissions
    //                     $over_prices            += $over_price;             // total over_price

    //                 }else{ // if user type is supervisor site
    //                     #calc commission
    //                     $bouns       = isset($user) ? floatval($user->bouns) : 0; // Bouns
    //                     $commission  = 0; // site commission
    //                     // supervisor site commission
    //                     $commission_supervisor    = count($providers) > 0 ? // check if order has delegate or shiping
    //                                                 $section->supervisor_delegate_commission + $bouns  //has delegate
    //                                                 :
    //                                                 $section->supervisor_shiping_commission + $bouns; // has shiping
    //                     #this item
    //                     $real_total            = $item->count * get_price($section , $item->count);     // real total
    //                     $over_price            = $item->total - $real_total;             // over price
    //                     $product_commission    = $item->count * $commission;             // site commissions
    //                     $supervisor_commission = $item->count * $commission_supervisor;  // supervisor site commissions
    //                     #total
    //                     $commissions            += $product_commission;     // total site commissions
    //                     $supervisor_commissions += $supervisor_commission;  // total supervisor site commissions
    //                     $over_prices            += $over_price;             // total over_price
    //                 }

    //                 $count_after_gift   = $item->count; //buy item count
    //                 $using_gift_count   = 0; //gift item count

    //                 $buy_total          = $count_after_gift * $section->buy_price; //Product Purchasing price
    //                 $gift_total         = $using_gift_count * $section->gift_price; //Product gift price
    //                 $buy_total          = $buy_total + $gift_total; //Total Product Purchasing price
    //                 $product_point      = $item->count * $point; // Product points
    //                 $product_benfit     = $item->total - $buy_total; // Product benfits
    //                 $benifts            = $benifts + $product_benfit; // add to total cart item benfits

    //                 //store order item
    //                 $items = new Order_item;
    //                 $items->order_id              = $add->id;
    //                 $items->section_id            = $item->section_id;
    //                 $items->count                 = $item->count;
    //                 $items->total                 = $item->total;            //selling price
    //                 $items->buy_total             = $buy_total;              //Purchasing price
    //                 $items->gift_total            = $gift_total;
    //                 $items->gift_count            = $using_gift_count;
    //                 $items->commission            = $product_commission;
    //                 $items->supervisor_commission = $supervisor_commission;
    //                 $items->over_price            = $over_price;
    //                 $items->point                 = $product_point;
    //                 $items->benfit                = $product_benfit;
    //                 $items->save();

    //                 $section->quantity  = $section->quantity - $item->count;
    //                 $section->save();
    //             } else { //if have not product quantity
    //                 // delete order
    //                 $add->delete();
    //                 return response()->json(['key' => 'fail', 'value' => 0, 'msg' => trans('api.qyentityTaken')]);
    //             }
    //         }

    //         // update order data
    //         $add->site_benfit        = $benifts;
    //         $add->site_commission    = $commissions;
    //         $add->supervisor_commission  = $supervisor_commissions;
    //         $add->over_price             = $over_prices;
    //         $add->site_point         = $points;
    //         $add->save();
    //     }
    //     else{
    //         foreach ($carts as $item) {
    //             $section = Section::whereId($item->section_id)->first();
    //             if ($section->quantity >= $item->count && $item->count > 0) { //if have product quantity
    //                 $count_after_gift   = $item->count; //buy item count
    //                 $using_gift_count   = 0; //gift item count

    //                 //check if have gifts on this product
    //                 $gift  = User_gift::where('user_id', Auth::id())->where('section_id', $section->id)->first();
    //                 if (isset($gift)) { //if has gift
    //                     $gift_count = $gift->count; //gift quantity
    //                     if ($gift_count >= $item->count) { //if gift more than or equal product quantity
    //                         $using_gift_count     = $item->count; //using gift quantity
    //                         $count_after_gift     = 0; // get count after gifts
    //                     } else { //if gift less than product quantity
    //                         $using_gift_count     = $gift_count; //using gift quantity
    //                         $count_after_gift     = $item->count - $gift_count; // get count after gifts
    //                     }

    //                     //remove using gift quantity
    //                     if ($gift->count - $using_gift_count > 0) { //if has gift
    //                         $gift->count = $gift->count - $using_gift_count;
    //                         $gift->save();
    //                     } else //if hasn't gift any more
    //                         $gift->delete();
    //                 }

    //                 $buy_total          = $count_after_gift * $section->buy_price; //Product Purchasing price
    //                 $gift_total         = $using_gift_count * $section->gift_price; //Product gift price
    //                 $buy_total          = $buy_total + $gift_total; //Total Product Purchasing price
    //                 $product_commission = $item->count * $commission; // Product commission
    //                 $product_point      = $item->count * $point; // Product points
    //                 $product_benfit     = $item->total - $buy_total; // Product benfits
    //                 $benifts            = $benifts + $product_benfit; // add to total cart item benfits

    //                 //store order item
    //                 $items = new Order_item;
    //                 $items->order_id    = $add->id;
    //                 $items->section_id  = $item->section_id;
    //                 $items->count       = $item->count;
    //                 $items->total       = $item->total; //selling price
    //                 $items->buy_total   = $buy_total; //Purchasing price
    //                 $items->gift_total  = $gift_total;
    //                 $items->gift_count  = $using_gift_count;
    //                 $items->commission  = $product_commission;
    //                 $items->point       = $product_point;
    //                 $items->benfit      = $product_benfit;
    //                 $items->save();

    //                 $section->quantity  = $section->quantity - $item->count;
    //                 $section->save();
    //             } else { //if have not product quantity
    //                 // delete order
    //                 $add->delete();
    //                 return response()->json(['key' => 'fail', 'value' => 0, 'msg' => trans('api.qyentityTaken')]);
    //             }
    //         }

    //         // update order data
    //         $add->site_benfit        = $benifts;
    //         $add->site_commission    = $commissions;
    //         $add->site_point         = $points;
    //         $add->save();
    //     }

    //     if (count($providers) > 0) { // delivery by delegates
    //         $add->delivery_type     = 'delegate';
    //         $add->save();

    //         foreach ($providers as $provider) {
    //             $send_order = new Order_provider;
    //             $send_order->order_id    = $add->id;
    //             $send_order->provider_id = $provider;
    //             $send_order->status      = 'new';
    //             $send_order->save();

    //             $user = User::whereId($provider)->first();
    //             if (isset($user) && $user->notify_send == 1) {
    //                 $lang = $user->lang;
    //                 $msg = [
    //                     'title_ar'    => 'العمدة باشا',
    //                     'title_en'    => 'Alomda Basha',
    //                     'blocked_ar'  => 'لديك حجز جديد رقم :  ' . $add->id,
    //                     'blocked_en'  => 'You have a new order No: ' . $add->id,
    //                 ];
    //                 $data   = [];
    //                 $data['title']      = $msg['title_' . $lang];
    //                 $data['msg']        = $msg['blocked_' . $lang];
    //                 $data['status']     = 'new_order';
    //                 $data['data_id']    = $add->id;
    //                 foreach ($user->Devices as $device) {
    //                     Send_FCM_Badge($device->device_id, $data, $device->device_type);
    //                 }

    //                 sendNotify(null, $user->id, $msg['blocked_ar'], $msg['blocked_en'], $add->id);
    //             }
    //         }
    //     } else { // delivery by shiping company
    //         $add->delivery_type     = 'company';
    //         $add->save();
    //     }

    //     #cart
    //     Cart::where('user_id', Auth::id())->delete();

    //     /** Send Success Massage **/
    //     return response()->json(['key' => 'success', 'value' => 1, 'msg' => trans('api.save')]);
    // }
}
