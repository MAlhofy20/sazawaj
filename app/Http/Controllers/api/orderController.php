<?php

namespace App\Http\Controllers\api;

#Basic
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#resources
use App\Http\Resources\userResource;
use App\Http\Resources\orderResource;
use App\Http\Resources\cartResource;
use App\Http\Resources\orderProviderResource;
use App\Http\Resources\user_addressResource;
use App\Http\Resources\offerResource;
#config->app
use Validator;
use Auth;
use Hash;
use DB;
#Mail
use Mail;
use App\Mail\ActiveCode;
#Models
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Notification;
use App\Models\Order_provider;
use App\Models\Section;
use App\Models\Sub_section;
use App\Models\Service;
use App\Models\Service_offer;
use App\Models\User_address;
use App\Models\Cart;
use App\Models\City;
use App\Models\Not_now_offer;
use App\Models\Promo_code;
use App\Models\User_account;
use App\Models\Device;
use App\Models\Neighborhood;
use App\Models\Order_time_static;
use App\Models\Service_option;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class orderController extends Controller
{
    public function __construct(Request $request)
    {
        //check_cart($request->user_id);

        checkOrderTime();
    }

    /*
    |---------------------------------------------|
    |                 Cart Pages                  |
    |---------------------------------------------|
    */

    #check price
    public function check_price(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'count'      => 'required',
            'size_id'    => 'nullable|exists:service_options,id',
            'option_id'  => 'nullable|exists:service_options,id',
            'side_id'    => 'nullable|exists:service_options,id',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return api_response('0', $validate->errors()->first());

        $price = get_service_price($request->service_id, $request->count, $request->size_id, $request->option_id, $request->side_id);

        /** Send Success Massage **/
        return api_response('1', 'تم الارسال', $price);
    }

    #store cart
    public function add_to_cart(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'user_id'    => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'option_id'  => 'nullable|exists:service_options,id',
            'count'      => 'nullable',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return api_response('0', $validate->errors()->first());

        /** add to cart **/
        $user = User::whereId($request->user_id)->first();
        //if ($user->user_type == 'market' && $user->confirm == 0) return api_response('0', 'حسابك غير مفعل قم بالتواصل مع الادارة');

        /** add to cart **/
        $service = Service::whereId($request->service_id)->first();
        $cart    = Cart::whereUserId($request->user_id)->whereServiceId($request->service_id)->first();
        $option  = Service_option::whereId($request->option_id)->first();
        //$price   = get_service_price($service->id, $request->count);

        if (isset($cart)) {
            $new_count = $request->has('count') && (int) $request->count > 0 ? (int) $request->count : 1;
            $count     = (int) $cart->count + $new_count;
            $cart->update([
                'notes'        => $request->has('notes') ? $request->notes : $cart->notes,
                'count'        => $count,
                //'option_id'    => !isset($option) ? $cart->option_id : $option->id,
                //'option_title' => !isset($option) ? $cart->option_title : $option->title_ar,
                //'option_price' => !isset($option) ? $cart->option_price : $option->price_with_value,
                'total'        => isset($option) ? $count * ($service->price_with_value + $option->price_with_value) : $count * $service->price_with_value,
                //'sub_total'    => isset($option) ? $count * ($service->price + $option->price) : $count * $service->price
            ]);

        } else {
            $count = $request->has('count') && (int) $request->count > 0 ? (int) $request->count : 1;
            $request->request->add([
                'section_id'   => $service->section_id,
                //'option_id'    => $request->option_id,
                //'option_title' => !isset($option) ? '' : $option->title_ar,
                //'option_price' => !isset($option) ? 0 : $option->price_with_value,
                'count'        => $count,
                'total'        => isset($option) ? $count * ($service->price_with_value + $option->price_with_value) : $count * $service->price_with_value,
                //'sub_total'    => isset($option) ? $count * ($service->price + $option->price) : $count * $service->price
            ]);
            Cart::create($request->except(['lang']));
        }

        /** Send Success Massage **/
        return api_response('1', trans('api.saveToCart'), [], ['notification_count' => user_notify_count($request->user_id)]);
    }

    #update cart
    public function update_to_cart(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'user_id'    => 'required|exists:users,id',
            'cart_id'    => 'required|exists:carts,id',
            'count'      => 'nullable',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return api_response('0', $validate->errors()->first());

        /** update cart **/
        $cart      = Cart::whereId($request->cart_id)->first();
        $price     = $cart->total / $cart->count;
        //$sub_total = $cart->sub_total / $cart->count;

        if ((int) $request->count > 0) {
            $cart->update([
                'notes'     => $request->has('notes') ? $request->notes : $cart->notes,
                'count'     => (int) $request->count,
                'total'     => (int) $request->count * $price,
                //'sub_total' => (int) $request->count * $sub_total,
            ]);

        } else {
            $cart->delete();
        }

        /** Send Success Massage **/
        return api_response('1', trans('api.Updated'), cartResource::collection(Cart::where('user_id', $request->user_id)->get()), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #show cart
    public function show_cart(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        /** Send Error Massages **/
        if ($validate->fails()) return api_response('0', $validate->errors()->first());

        /** get cart Data **/
        $data = cartResource::collection(Cart::where('user_id', $request->user_id)->get());

        $total               = (float) Cart::where('user_id', $request->user_id)->sum('total');
        $sub_total           = (float) Cart::where('user_id', $request->user_id)->sum('total');
        $value_added         = $total - $sub_total;
        $value_added_percent = (float) settings('value_added');
        $delivery            = (float) settings('delivery');

        $sub_data = [
            //'value_added'        => (float) settings('value_added'),
            'sub_total_with_value'  => round($total, 2),
            'sub_total'             => round($sub_total, 2),
            'value_added_percent'   => $value_added_percent,
            'value_added'           => round($value_added, 2),
            'delivery'              => $delivery,
            //'total'                 => $sub_total + $value_added + $delivery,
            'total'                 => round($total, 2) + $delivery,
            'notification_count'    => (float) user_notify_count($request->user_id),
            'cart_count'            => Cart::where('user_id', $request->user_id)->count(),
            'addresses'             => user_addressResource::collection(User_address::whereUserId($request->user_id)->get())
        ];

        /** Send Success Massage **/
        return api_response('1', trans('api.send'), $data, $sub_data);
    }

    #check price
    public function check_order_total(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'city_from_id'  => 'required|exists:cities,id',
            'city_to_id'    => 'required|exists:cities,id',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return api_response('0', $validate->errors()->first());

        $price = get_order_price($request->city_from_id, $request->city_to_id, $request->count);

        /** Send Success Massage **/
        return api_response('1', $price);
    }

    #check promo code
    public function checkPromo(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required|exists:users,id',
            'code'         => 'required',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        # get discount
        $discount = check_promo_code($request->user_id, $request->code);
        #invalid promo code
        if ($discount == 0) return api_response(0, trans('api.invaildPromo'), $discount);
        #success promo code
        return api_response(1, trans('api.send'), $discount);
    }

    #show times
    public function show_times(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'     => 'nullable|exists:users,id',
            'provider_id' => 'required|exists:users,id',
            'amount'      => 'required',
            'date'        => 'required',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        # get discount
        $data = show_times($request->provider_id, $request->date, $request->amount);

        #success promo code
        return api_response(1, trans('api.send'), $data);
    }

    /*
    |---------------------------------------------|
    |                 order Pages                 |
    |---------------------------------------------|
    */

    #store order saler
    public function storeOrder(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            #basic
            'user_id'            => 'required|exists:users,id',
            'provider_id'        => 'required|exists:users,id',
            'name'               => 'required',
            'amount'             => 'required',
            'date'               => 'required',
            'time'               => 'required',
            // 'delivery'           => 'nullable',
            // 'value_added'        => 'nullable',
            'total_before_promo' => 'required',
            'total_after_promo'  => 'required',
            'payment_method'     => 'required|in:cash,transfer,online',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #Promo data
        $promo_id = null;
        if (!empty($request->promo_code)) {
            $promo    = Promo_code::where('code', $request->promo_code)->first();
            $promo_id = isset($promo) ? $promo->id : null;
        }

        #data
        // $service       = Service::whereId($request->service_id)->first();
        // $option        = Service_option::whereId($request->option_id)->first();
        // $sub_total     = isset($option) ? $service->price + $option->price : $service->price;
        // $total         = isset($option) ? $service->price_with_value + $option->price_with_value : $service->price_with_value;
        // $discount      = isset($promo) ? $total * $promo->discount / 100 : 0;
        // $total_w_promo = $total - $discount;


        #store order
        $user     = User::whereId($request->user_id)->first();
        $provider = User::whereId($request->provider_id)->first();
        // $manager  = User::whereId($provider->manager_id)->first();

        $amount = (int) $request->amount;
        $date   = Carbon::parse($request->date)->format('Y-m-d');
        $start  = Carbon::parse($request->date . $request->time)->format('H:i:s');
        $end    = Carbon::parse($request->date . $request->time)->addMinutes($amount)->format('H:i:s');
        $count  = 0;
        for ($i = 1; $i <= $provider->count; $i++) {
            if(check_times($provider->id, $date, $start, $end, $amount, $i)) {
                $count = $i;
                break;
            }
        }

        if($count == 0) return api_response(0, Translate('الوقت غير متاح'));

        // $address = User_address::whereId($request->address_id)->first();
        // if (!isset($address)) {
        //     $address = User_address::create([
        //         'title'     => $request->title,
        //         'address'   => $request->address,
        //         'lat'       => $request->lat,
        //         'lng'       => $request->lng,
        //         'user_id'   => $request->user_id,
        //     ]);
        // }

        $request->request->add([
            'status'     => $request->payment_method == 'online' ? 'current' : 'new',
            'is_paid'    => $request->payment_method == 'transfer' ? 0 : 1,
            'user_name'  => $user->name,
            'user_phone' => $user->phone,
            'date'       => $date,
            'time'       => $start,
            'end_time'   => $end,
            'count'      => $count,
        ]);
        $order = Order::create($request->except(['lang']));

        // if($request->payment_method == 'online') {
            foreach (generateTimeRangeWithDate($start, $end, 1, $date) as $item) {
                Order_time_static::create([
                    'order_id'    => $order->id,
                    'provider_id' => $request->provider_id,
                    'user_id'     => $request->user_id,
                    'count'       => $count,
                    'date'        => isset($item['date']) ? $item['date'] : $request->date,
                    'time'        => isset($item['time']) ? $item['time'] : $request->time,
                ]);
            }
        // }

        #add user id to promo code
        if (isset($promo)) {
            //dd($promo->type);
            if ($promo->type == 'one_use') $promo->update(['status' => 'invalid']);
            elseif ($promo->type == 'more_use') {
                $used_by_arr = is_null($promo->used_by) ? [] : json_decode($promo->used_by);
                array_push($used_by_arr, $request->user_id);
                $promo->update(['used_by' => json_encode($used_by_arr)]);
            }
        }

        #sent notify to user
        /*$lang = $user->lang == 'en' ? 'en' : 'ar';
        if ($request->payment_method == 'online') {
            $msg  = [
                'title_ar'    => 'عزيزي العميل تم تأكيد حجزك رقم :' . $order->id,
                'title_en'    => 'Your Order No : ' . $order->id . ' is confirmed',
            ];
        }else {
            $msg  = [
                'title_ar'    => 'عزيزي العميل تم ارسال حجزك رقم :' . $order->id,
                'title_en'    => 'Your Order No : ' . $order->id . ' is sent',
            ];
        }

        $message = $msg['title_' . $lang];
        send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
        foreach ($user->devices as $device) {
            $device_id   = $device->device_id;
            if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
        }*/

        if(isset($user)) {
            $lang = $user->lang == 'en' ? 'en' : 'ar';
            if ($request->payment_method == 'online') {
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم تأكيد حجزك رقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is confirmed',
                ];
            }else {
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم ارسال حجزك رقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is sent',
                ];
            }

            $message = $msg['title_' . $lang];
            $data    = ['title' => settings('site_name'), 'body' => $message];
            send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
            foreach (Device::whereUserId($user->id)->get() as $device) {
                $device_id = $device->device_id;
                //if (!is_null($device_id)) send_one_signal($message, $device_id);
                if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
            }
        }

        //<p>شكراً لثقتكم بنا.</p>
        //<p>مع خالص التحية،</p>
        if(isset($user)) {
            $title = '<html dir="rtl"><head><title></title></head><body><p>عزيزي العميل ' . $user->name . ',</p><p>نشكرك على اختيارك لخدماتنا. يسرنا أن نعلمك أن حجزك قد تم بنجاح. يرجى الاطلاع على تفاصيل الحجز أدناه</p><p>رقم الحجز: ' . $order->id . '</p><p>اسم الملعب: ' . $provider->full_name_ar . '</p><p>تاريخ الحجز: ' . $order->date . '</p><p>بداية الحجز: ' . Carbon::parse($order->time)->format('H:i') . '</p><p>نهاية الحجز: ' . Carbon::parse($order->time)->addMinutes((int) $order->amount)->format('H:i') . '</p></body></html>';
            send_mail_html($user->email, $title);
        }

        if (isset($provider)) {
            $title = '<html dir="rtl"><head><title></title></head><body><p>حجز جديد</p><p>رقم الحجز: ' . $order->id . '</p><p>تاريخ الحجز: ' . $order->date . '</p><p>بداية الحجز: ' . Carbon::parse($order->time)->format('H:i') . '</p><p>نهاية الحجز: ' . Carbon::parse($order->time)->addMinutes((int) $order->amount)->format('H:i') . '</p></body></html>';
            send_mail_html($provider->email, $title);

            #send fcm to manager
            foreach ($provider->devices as $device) {
                $token = $device->device_id;
                Send_FCM_Badge_naitve(['title' => 'طلب جديد', 'msg' => 'هناك طلب جديد'], $token);
            }
        }

        if(!empty(settings('email'))) {
            $title = '<html dir="rtl"><head><title></title></head><body><p>حجز جديد</p><p>رقم الحجز: ' . $order->id . '</p><p>اسم الملعب: ' . $provider->full_name_ar . '</p><p>تاريخ الحجز: ' . $order->date . '</p><p>بداية الحجز: ' . Carbon::parse($order->time)->format('H:i') . '</p><p>نهاية الحجز: ' . Carbon::parse($order->time)->addMinutes((int) $order->amount)->format('H:i') . '</p></body></html>';
            send_mail_html(settings('email'), $title);
        }

        $tokens = Device::whereHas('user', function ($q) {
            return $q->where('user_type', 'admin');
        })->where('device_type', 'web')->pluck('device_id')->toArray();
        foreach ($tokens as $token) {
            Send_FCM_Badge_naitve(['title' => 'طلب جديد', 'msg' => 'هناك طلب جديد'], $token);
        }

        #send fcm to admin
        // $tokens = Device::where('device_type', 'web')->pluck('device_id')->toArray();
        // foreach ($tokens as $token){
        //     Send_FCM_Badge_naitve(['title' => 'طلب جديد', 'msg' => 'هناك طلب جديد'], $token);
        // }

        #success response
        return api_response(1, trans('api.save'), new orderResource($order), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #store order market
    public function storeOrderMarket(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            #basic
            'user_id'            => 'required|exists:users,id',
            'address'            => 'nullable',
            'lat'                => 'nullable',
            'lng'                => 'nullable',
            'delivery'           => 'nullable',
            'value_added'        => 'nullable',
            'total_before_promo' => 'nullable',
            'total_after_promo'  => 'nullable',
            'payment_method'     => 'nullable|in:cash,transfer,online,not_now',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #json decode
        $items = Cart::where('user_id', $request->user_id)->get();

        #faild response
        if (count($items) == 0) return api_response(0, Translate('لا يوجد منتجات بالسلة'));

        #Promo data
        $promo_id = null;
        if (!empty($request->promo_code)) {
            $promo    = Promo_code::where('code', $request->promo_code)->first();
            $promo_id = isset($promo) ? $promo->id : null;
        }

        #store order
        $user    = User::whereId($request->user_id)->first();
        $address = User_address::whereId($request->address_id)->first();
        if (!isset($address)) {
            $address = User_address::create([
                'title'   => $request->title,
                'address' => $request->address,
                'lat'     => $request->lat,
                'lng'     => $request->lng,
                'user_id' => $request->user_id,
            ]);
        }

        $total               = (float) Cart::where('user_id', $request->user_id)->sum('total');
        $sub_total           = (float) Cart::where('user_id', $request->user_id)->sum('total');
        $value_added         = $total - $sub_total;
        $value_added_percent = (float) settings('value_added');
        $delivery            = (float) settings('delivery');
        $discount            = isset($promo) ? $total * $promo->discount / 100 : 0;
        $total_w_promo       = $total - $discount;

        $request->request->add([
            'status'             => 'new',
            'type'               => 'market',
            'is_paid'            => $request->payment_method == 'transfer' ? 0 : 1,
            'user_name'          => $user->name,
            'user_phone'         => $user->phone,
            'sub_total'          => $sub_total,
            'delivery'           => $delivery,
            'value_added'        => $value_added,
            'total_before_promo' => $total,
            'total_after_promo'  => $total_w_promo,
            'promo_id'           => $promo_id,
            'promo_code'         => isset($promo) ? $promo->code : '',
            'address'            => $address->address,
            'lat'                => $address->lat,
            'lng'                => $address->lng,
        ]);
        $order = Order::create($request->except(['lang', 'title', 'address_id']));

        $items               = Cart::where('user_id', $request->user_id)->get();
        $total               = (float) Cart::where('user_id', $request->user_id)->sum('total');
        $sub_total           = (float) Cart::where('user_id', $request->user_id)->sum('total');
        $value_added         = $total - $sub_total;
        $value_added_percent = (float) settings('value_added');
        $delivery            = (float) settings('delivery');
        $discount            = isset($promo) ? $total * $promo->discount / 100 : 0;
        $total_w_promo       = $total - $discount;

        $request->request->add([
            'order_id'           => $order->id,
            'type'               => 'market',
            'is_paid'            => $request->payment_method == 'transfer' ? 0 : 1,
            'user_name'          => $user->name,
            'user_phone'         => $user->phone,
            'sub_total'          => $sub_total,
            'delivery'           => $delivery,
            'value_added'        => $value_added,
            'total_before_promo' => $total,
            'total_after_promo'  => $total_w_promo,
            'promo_id'           => $promo_id,
            'promo_code'         => isset($promo) ? $promo->code : '',
            'address'            => $address->address,
            'lat'                => $address->lat,
            'lng'                => $address->lng,
        ]);
        $order_provider = Order::create($request->except(['lang', 'title', 'address_id']));

        #store order items
        foreach ($items as $item) {
            $service    = Service::whereId($item->service_id)->first();
            //$service_arr[] = $service->id;
            Order_item::create([
                'order_id'         => $order->id,
                'service_id'       => $service->id,
                'service_title_ar' => $service->title_ar,
                'service_title_en' => $service->title_en,
                'option_id'        => $item->option_id,
                'option_title'     => $item->option_title,
                'option_price'     => $item->option_price,
                'total'            => $item->total,
                //'total_with_value' => $service->price_with_value,
                'value_added'      => $item->total,
                'notes'            => $item->notes,
                'count'            => $item->count,
            ]);

            Order_item::create([
                'order_id'         => $order_provider->id,
                'service_id'       => $service->id,
                'service_title_ar' => $service->title_ar,
                'service_title_en' => $service->title_en,
                'option_id'        => $item->option_id,
                'option_title'     => $item->option_title,
                'option_price'     => $item->option_price,
                'total'            => $item->total,
                //'total_with_value' => $service->price_with_value,
                'value_added'      => $item->total,
                'notes'            => $item->notes,
                'count'            => $item->count,
            ]);
        }

        #add user id to promo code
        if (isset($promo)) {
            //dd($promo->type);
            if ($promo->type == 'one_use') $promo->update(['status' => 'invalid']);
            elseif ($promo->type == 'more_use') {
                $used_by_arr = is_null($promo->used_by) ? [] : json_decode($promo->used_by);
                array_push($used_by_arr, $request->user_id);
                $promo->update(['used_by' => json_encode($used_by_arr)]);
            }
        }

        #sent notify to user
        $lang = $user->lang == 'en' ? 'en' : 'ar';
        $msg  = [
            'title_ar' => 'عزيزي العميل تم ارسال طلبك برقم :' . $order->id,
            'title_en' => 'Your Order No : ' . $order->id . ' is sent',
        ];
        /*$message = $msg['title_' . $lang];
        send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
        foreach ($user->devices as $device) {
            $device_id   = $device->device_id;
            if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
        }*/

        if(isset($user)) {
            $message = $msg['title_' . $lang];
            $data    = ['title' => settings('site_name'), 'body' => $message];
            send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
            foreach (Device::whereUserId($user->id)->get() as $device) {
                $device_id = $device->device_id;
                //if (!is_null($device_id)) send_one_signal($message, $device_id);
                if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
            }
        }

        #send fcm to provider
        $tokens = Device::where('device_type', 'web')->pluck('device_id')->toArray();
        foreach ($tokens as $token){
            Send_FCM_Badge_naitve(['title' => 'طلب جديد', 'msg' => 'هناك طلب جديد'], $token);
        }

        #delete cart
        Cart::where('user_id', $request->user_id)->delete();

        #success response
        return api_response(1, trans('api.save'), new orderResource($order), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #show all orders
    public function showAllOrders(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'status'    => 'nullable|in:new,has_provider,received,in_stock,second_provider,in_way,finish,waiting,refused',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $orders = Order::where('user_id', $request->user_id)->whereNull('order_id')->orderBy('id', 'desc')->get();
        if (!empty($request->status)) $orders = Order::where('user_id', $request->user_id)->whereNull('order_id')->where('status', $request->status)->orderBy('id', 'desc')->get();

        // $new_orders_count = Order::where('user_id', $request->user_id)->whereNull('order_id')->whereIn('status', ['new'])->count();
        // $current_orders_count = Order::where('user_id', $request->user_id)->whereNull('order_id')->whereNotIn('status', ['new', 'finish', 'refused', 'cancel'])->count();
        // $finish_orders_count = Order::where('user_id', $request->user_id)->whereNull('order_id')->whereIn('status', ['finish'])->count();

        #success response
        return api_response(1, trans('api.send'), orderResource::collection($orders), [
            'notification_count'   => user_notify_count($request->user_id),
            'cart_count'           => user_cart_count($request->user_id)
            // 'new_orders_count'     => $new_orders_count,
            // 'current_orders_count' => $current_orders_count,
            // 'finish_orders_count'  => $finish_orders_count,
        ]);
    }

    #search all orders
    public function searchAllOrders(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'   => 'nullable|exists:users,id',
            'filter'    => 'nullable',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $query = Order::query();
        $query->whereNull('order_id');
        $query->where('id', $request->order_id);
        $query->where('user_phone', $request->phone);
        $order = $query->first();

        #success response
        return api_response(1, trans('api.send'), isset($order) ? new orderResource($order) : [], ['notification_count' => user_notify_count($request->user_id), 'cart_count' => user_cart_count($request->user_id)]);
    }

    #show all provider orders
    public function showAllProviderOrders(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'status'    => 'nullable|in:new,current,in_way,refused,finish',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $orders = Order::where('delegate_id', $request->user_id)->whereNull('order_id')->orderBy('id', 'desc')->get();
        if (!empty($request->status)) $orders = Order::where('delegate_id', $request->user_id)->where('status', $request->status)->whereNull('order_id')->orderBy('id', 'desc')->get();

        #success response
        return api_response(1, trans('api.send'), orderResource::collection($orders), ['notification_count' => user_notify_count($request->user_id)]);

        /*if ($request->status == 'new') {
            $orders = Order_provider::whereHas('Order', function ($q) {
                return $q->whereNotNull('user_id')->whereIn('status', ['new', 'in_way']);
            })->where('provider_id', $request->user_id)->whereStatus('new')->orderBy('id', 'desc')->get();

            #success response
            return api_response(1, trans('api.send'), orderProviderResource::collection($orders), ['notification_count' => user_notify_count($request->user_id)]);
        } else {
            $orders = Order::where('delegate_id', $request->user_id)->orderBy('id', 'desc')->get();
            if (!empty($request->status)) $orders = Order::where('delegate_id', $request->user_id)->where('status', $request->status)->orderBy('id', 'desc')->get();

            #success response
            return api_response(1, trans('api.send'), orderResource::collection($orders), ['notification_count' => user_notify_count($request->user_id)]);
        }*/
    }

    #show order
    public function showOrder(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'  => 'nullable|exists:users,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #success response
        return api_response(1, trans('api.save'), new orderResource(Order::whereId($request->order_id)->first()), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #change order status
    public function change_order_status(Request $request)
    {
        /** Validate Request **/
        $validator = Validator::make($request->all(), [
            'order_id'  => 'required|exists:orders,id', // order_id
            'user_id'   => 'required|exists:users,id', // delgate_id
            'delivery'  => 'nullable', // status = agree
            'status'    => 'required', // agree , refused , in_way , finish , cancel
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $order   = Order::whereId($request->order_id)->first();

        if ($request->status == 'refused') { //refused order
            #data
            $user    = User::whereId($request->user_id)->first();
            $client  = User::whereId($order->user_id)->first();
            $order_provider = Order_provider::whereOrderId($request->order_id)->whereProviderId($request->user_id)->first();

            if (isset($order_provider)) $order_provider->delete();

            if ($order->status == 'new') Order_provider::where('order_id', $request->order_id)->update(['status' => 'new']);

            #success response
            return api_response(1, Translate('تم الرفض'));
        } elseif ($request->status == 'agree') { //agree order
            #data
            $delegate  = User::whereId($request->user_id)->first();
            $user      = User::whereId($order->user_id)->first();
            #delegate percent
            $delegate_percent = 0;
            $profit_delegate  = 0;
            if (isset($delegate)) {
                $delegate_percent = empty($delegate->admin_percent) ? (float) settings('provider_percent') : (float) $delegate->admin_percent;
                $profit_delegate  = (float) $order->delivery * $delegate_percent / 100;
            }

            if (!empty($order->delegate_id))  return api_response(0, Translate('هناك مندوب بالفعل لهذا الطلب'));

            $order->update([
                'status'        => 'in_way',
                'delegate_id'   => $request->user_id,
                'delgate_debt'  => $profit_delegate,
            ]);

            Order_provider::where('order_id', $request->order_id)->delete();

            #sent notify to user
            /*if (isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل جاري توصيل طلبك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' in way',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'in_way');
                foreach ($user->devices as $device) {
                    $device_id   = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }*/

            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل جاري توصيل طلبك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' in way',
                ];
                $message = $msg['title_' . $lang];
                $data    = ['title' => settings('site_name'), 'body' => $message];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
                foreach (Device::whereUserId($user->id)->get() as $device) {
                    $device_id = $device->device_id;
                    //if (!is_null($device_id)) send_one_signal($message, $device_id);
                    if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
                }
            }

            #success response
            return api_response(1, Translate('تم القبول'));
        } elseif ($request->status == 'cancel') { //cancel order
            #data
            $user      = User::whereId($order->user_id)->first();

            if ($order->status != 'new')  return api_response(0, Translate('لا يمكن الغاء هذا الطلب'));

            $order->update([
                'status'        => 'refused',
                'delegate_id'   => null,
                'delgate_debt'  => 0,
            ]);

            Order_provider::where('order_id', $request->order_id)->delete();

            #sent notify to user
            /*if (isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم الغاء طلبك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is refused',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'refused');
                foreach ($user->devices as $device) {
                    $device_id   = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }*/

            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم الغاء طلبك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is refused',
                ];
                $message = $msg['title_' . $lang];
                $data    = ['title' => settings('site_name'), 'body' => $message];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
                foreach (Device::whereUserId($user->id)->get() as $device) {
                    $device_id = $device->device_id;
                    //if (!is_null($device_id)) send_one_signal($message, $device_id);
                    if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
                }
            }

            #success response
            return api_response(1, Translate('تم الالغاء'));
        } elseif ($request->status == 'in_way') { //in way order
            #data
            $delegate  = User::whereId($request->user_id)->first();
            $user      = User::whereId($order->user_id)->first();
            #delegate percent
            $delegate_percent = 0;
            $profit_delegate  = 0;
            if (isset($delegate)) {
                $delegate_percent = empty($delegate->admin_percent) ? (float) settings('provider_percent') : (float) $delegate->admin_percent;
                $profit_delegate  = (float) $order->delivery * $delegate_percent / 100;
            }

            if (!empty($order->delegate_id))  return api_response(0, Translate('هناك مندوب بالفعل لهذا الطلب'));

            $order->update([
                'status'        => 'in_way',
                'delegate_id'   => $request->user_id,
                'delgate_debt'  => $profit_delegate,
            ]);

            Order_provider::where('order_id', $request->order_id)->delete();

            #sent notify to user
            /*if (isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم ارسال طلبك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is deliverd',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'in_way');
                foreach ($user->devices as $device) {
                    $device_id   = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }*/

            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg  = [
                    'title_ar'    => 'عزيزي العميل تم ارسال طلبك برقم :' . $order->id,
                    'title_en'    => 'Your Order No : ' . $order->id . ' is deliverd',
                ];
                $message = $msg['title_' . $lang];
                $data    = ['title' => settings('site_name'), 'body' => $message];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
                foreach (Device::whereUserId($user->id)->get() as $device) {
                    $device_id = $device->device_id;
                    //if (!is_null($device_id)) send_one_signal($message, $device_id);
                    if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
                }
            }

            #success response
            return api_response(1, Translate('تم القبول'));
        } elseif ($request->status == 'finish') { //finish order
            #data
            $user       = User::whereId($order->user_id)->first();
            $provider   = User::whereId($order->provider_id)->first();
            $delegate   = User::whereId($order->delegate_id)->first();

            #sent notify to user
            /*if (isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg = [
                    'title_ar' => 'عزيزي العميل تم توصيل طلبك برقم :' . $order->id,
                    'title_en' => 'Your Order No : ' . $order->id . ' is finished',
                ];
                $message = $msg['title_' . $lang];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
                foreach ($user->devices as $device) {
                    $device_id = $device->device_id;
                    if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
                }
            }*/

            if(isset($user)) {
                $lang = $user->lang == 'en' ? 'en' : 'ar';
                $msg = [
                    'title_ar' => 'عزيزي العميل تم توصيل طلبك برقم :' . $order->id,
                    'title_en' => 'Your Order No : ' . $order->id . ' is finished',
                ];
                $message = $msg['title_' . $lang];
                $data    = ['title' => settings('site_name'), 'body' => $message];
                send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
                foreach (Device::whereUserId($user->id)->get() as $device) {
                    $device_id = $device->device_id;
                    //if (!is_null($device_id)) send_one_signal($message, $device_id);
                    if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
                }
            }

            #delegate percent
            $delegate_percent = 0;
            $profit_delegate  = 0;
            $need_delegate    = 0;
            if (isset($delegate)) {
                $delegate_percent = empty($delegate->admin_percent) ? (float) settings('provider_percent') : (float) $delegate->admin_percent;
                $profit_delegate  = (float) $order->delivery * $delegate_percent / 100;
                $need_delegate    = (float) $order->delivery - $profit_delegate;
            }

            $order->update([
                'status'           => 'finish',
                'delgate_debt'     => $profit_delegate,
                'delgate_profit'   => $need_delegate,
            ]);

            $provider   = User::whereId($order->provider_id)->first();
            if (isset($provider)) {
                $percent          = $provider->user_type . '_percent';
                $provider_percent = empty($provider->admin_percent) ? (float) settings($percent) : (float) $provider->admin_percent;
                $profit_provider  = (float) $order->total_after_promo * $provider_percent / 100;
                $need_provider    = (float) $order->total_after_promo - $profit_provider;

                $order->update([
                    'provider_debt'    => $profit_provider,
                    'provider_profit'  => $need_provider,
                ]);

                $admin_recived = 0;
                $user_recived  = 0;
                if ($order->payment_method == 'cash' && $order->provider_id == $order->delegate_id) $user_recived = $order->total_after_promo;
                else $admin_recived = $order->total_after_promo;

                User_account::create([
                    'user_id'           => $provider->id,
                    'order_id'          => $order->id,
                    'total'             => $order->total_after_promo,
                    'admin_benfit'      => $profit_provider,
                    'user_benfit'       => $order->total_after_promo - $profit_provider,
                    'admin_recived'     => $admin_recived,
                    'user_recived'      => $user_recived,
                ]);

                $need = (float) $provider->total_user_debt;
                $debt = (float) $provider->total_admin_debt;

                if ($order->payment_method == 'cash' && $order->provider_id == $order->delegate_id) {
                    $provider->update([
                        'total_user_benfit'     => $provider->total_user_benfit + $need_provider,
                        'total_admin_benfit'    => $provider->total_admin_benfit + $profit_provider,
                        'total_user_debt'       => $need >= $profit_provider ? $need - $profit_provider : 0,
                        'total_admin_debt'      => $profit_provider > $need ? $debt + ($profit_provider - $need) : $debt + 0,
                    ]);
                } else {
                    $provider->update([
                        'total_user_benfit'     => $provider->total_user_benfit + $need_provider,
                        'total_admin_benfit'    => $provider->total_admin_benfit + $profit_provider,
                        'total_user_debt'       => $need_provider > $debt ? $need + ($need_provider - $debt) : $need + 0,
                        'total_admin_debt'      => $debt >= $need_provider ? $debt - $need_provider : 0,
                    ]);
                }
            }

            foreach ($order->orders as $item) {
                $provider   = User::whereId($item->provider_id)->first();
                if (isset($provider)) {
                    $percent          = $provider->user_type . '_percent';
                    $provider_percent = empty($provider->admin_percent) ? (float) settings($percent) : (float) $provider->admin_percent;
                    $profit_provider  = (float) $item->total_after_promo * $provider_percent / 100;
                    $need_provider    = (float) $item->total_after_promo - $profit_provider;

                    $item->update([
                        'provider_debt'    => $profit_provider,
                        'provider_profit'  => $need_provider,
                    ]);

                    $order->update([
                        'provider_debt'    => $order->provider_debt + $profit_provider,
                        'provider_profit'  => $order->provider_profit + $need_provider,
                    ]);

                    $admin_recived = 0;
                    $user_recived  = 0;
                    if ($order->payment_method == 'cash' && $item->provider_id == $order->delegate_id) $user_recived = $item->total_after_promo;
                    else $admin_recived = $item->total_after_promo;

                    User_account::create([
                        'user_id'           => $provider->id,
                        'order_id'          => $item->id,
                        'total'             => $item->total_after_promo,
                        'admin_benfit'      => $profit_provider,
                        'user_benfit'       => $item->total_after_promo - $profit_provider,
                        'admin_recived'     => $admin_recived,
                        'user_recived'      => $user_recived,
                    ]);

                    $need = (float) $provider->total_user_debt;
                    $debt = (float) $provider->total_admin_debt;

                    if ($order->payment_method == 'cash' && $order->provider_id == $order->delegate_id) {
                        $provider->update([
                            'total_user_benfit'     => $provider->total_user_benfit + $need_provider,
                            'total_admin_benfit'    => $provider->total_admin_benfit + $profit_provider,
                            'total_user_debt'       => $need >= $profit_provider ? $need - $profit_provider : 0,
                            'total_admin_debt'      => $profit_provider > $need ? $debt + ($profit_provider - $need) : $debt + 0,
                        ]);
                    } else {
                        $provider->update([
                            'total_user_benfit'     => $provider->total_user_benfit + $need_provider,
                            'total_admin_benfit'    => $provider->total_admin_benfit + $profit_provider,
                            'total_user_debt'       => $need_provider > $debt ? $need + ($need_provider - $debt) : $need + 0,
                            'total_admin_debt'      => $debt >= $need_provider ? $debt - $need_provider : 0,
                        ]);
                    }
                }
            }

            $delegate   = User::whereId($order->delegate_id)->first();
            if (isset($delegate)) {
                $admin_recived = 0;
                $user_recived  = 0;
                if ($order->payment_method == 'cash') $user_recived = $order->delivery;
                else $admin_recived = $order->delivery;

                User_account::create([
                    'user_id'           => $delegate->id,
                    'order_id'          => $order->id,
                    'total'             => $order->delivery,
                    'admin_benfit'      => $profit_delegate,
                    'user_benfit'       => $order->delivery - $profit_delegate,
                    'admin_recived'     => $admin_recived,
                    'user_recived'      => $user_recived,
                ]);

                $need = (float) $delegate->total_user_debt;
                $debt = (float) $delegate->total_admin_debt;

                if ($order->payment_method == 'cash') {
                    $delegate->update([
                        'total_user_benfit'     => $delegate->total_user_benfit + $need_delegate,
                        'total_admin_benfit'    => $delegate->total_admin_benfit + $profit_delegate,
                        'total_user_debt'       => $need >= $profit_delegate ? $need - $profit_delegate : 0,
                        'total_admin_debt'      => $profit_delegate > $need ? $debt + ($profit_delegate - $need) : $debt + 0,
                    ]);
                } else {
                    $delegate->update([
                        'total_user_benfit'     => $delegate->total_user_benfit + $need_delegate,
                        'total_admin_benfit'    => $delegate->total_admin_benfit + $profit_delegate,
                        'total_user_debt'       => $need_delegate > $debt ? $need + ($need_delegate - $debt) : $need + 0,
                        'total_admin_debt'      => $debt >= $need_delegate ? $debt - $need_delegate : 0,
                    ]);
                }
            }

            #success response
            return api_response(1, Translate('تم الانتهاء'));
        }
    }

    /*
    |----------------------------------------------------|
    |----------------------------------------------------|
    |            API token location Start                |
    |----------------------------------------------------|
    |----------------------------------------------------|
    */

    #check price
    public function api_check_order_total(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'city_from_id'  => 'required|exists:cities,id',
            'city_to_id'    => 'required|exists:cities,id',
            'count'         => 'required',
        ]);

        /** Send Error Massages **/
        if ($validate->fails())
            return api_response('0', $validate->errors()->first());

        $price = get_order_price($request->city_from_id, $request->city_to_id, $request->count);

        /** Send Success Massage **/
        return api_response('1', $price);
    }

    #check promo code
    public function api_checkPromo(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'api_token'    => 'required|exists:users,api_token',
            'code'         => 'required',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $user = User::where('api_token', $request->api_token)->first();
        $request->request->add([ 'user_id'  => isset($user) ? $user->id : 0 ]);

        # get discount
        $discount = check_promo_code($request->user_id, $request->code);
        #invalid promo code
        if ($discount == 0) return api_response(0, trans('api.invaildPromo'), $discount);
        #success promo code
        return api_response(1, trans('api.send'), $discount);
    }

    #store order
    public function api_storeOrder(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            #basic
            'api_token'          => 'required|exists:users,api_token',
            'section_id'         => 'required|exists:sections,id',
            'start_name'         => 'required',
            'start_phone'        => 'required',
            'start_lat'          => 'required',
            'start_lng'          => 'required',
            'start_address'      => 'required',
            'start_city_id'      => 'required|exists:cities,id',
            'end_name'           => 'required',
            'end_phone'          => 'required',
            'end_lat'            => 'required',
            'end_lng'            => 'required',
            'end_address'        => 'required',
            'end_city_id'        => 'required|exists:cities,id',
            'is_coverd'          => 'required|in:1,0',
            'sub_total'          => 'required',
            'value_added'        => 'required',
            'total_before_promo' => 'required',
            'total_after_promo'  => 'required',
            'payment_method'     => 'required|in:cash,transfer,online,not_now',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $user = User::where('api_token', $request->api_token)->first();
        $request->request->add([ 'user_id'  => isset($user) ? $user->id : 0 ]);

        #Promo data
        $promo_id = null;
        if (!empty($request->promo_code)) {
            $promo    = Promo_code::where('code', $request->promo_code)->first();
            $promo_id = isset($promo) ? $promo->id : null;
        }

        #store order
        $user    = User::whereId($request->user_id)->first();
        $section = Section::whereId($request->section_id)->first();
        $request->request->add([
            'status'              => 'new',
            'start_address_desc'  => $request->addressDetails,
            'end_address_desc'    => $request->addressDetailsRecipient,
            'package_total'       => $request->merchandise_value,
            'cover_price'         => (bool) $request->is_coverd ? (float) settings('packaging') : 0,
            'section_title_ar'    => $section->title_ar,
            'section_title_en'    => $section->title_en,
            'user_name'           => $user->name,
            'user_phone'          => $user->phone,
            'promo_id'            => $promo_id,
            'order_number'        => $request->user_id . date('md') . rand(11, 99),
        ]);
        $order = Order::create($request->except(['lang', 'addressDetails', 'addressDetailsRecipient', 'merchandise_value']));

        #send code to client's end phone
        $full_phone = convert_phone_to_international_format($request->end_phone, '966');
        $msg = 'كود استلام الشحنة : ' . $order->order_number;
        sms_zain($full_phone, $msg, 'msg');

        #add user id to promo code
        if (isset($promo)) {
            //dd($promo->type);
            if ($promo->type == 'one_use') $promo->update(['status' => 'invalid']);
            elseif ($promo->type == 'more_use') {
                $used_by_arr = is_null($promo->used_by) ? [] : json_decode($promo->used_by);
                array_push($used_by_arr, $request->user_id);
                $promo->update(['used_by' => json_encode($used_by_arr)]);
            }
        }

        #provider
        $provider   = User::where('user_type', 'provider')
            ->where('blocked', '0')
            ->where('confirm', '1')
            ->where('active', '1')
            ->having('distance', '<=', 10000000000)
            ->select(
                DB::raw("*,
                    (3959 * ACOS(COS(RADIANS($request->start_lat))
                    * COS(RADIANS(lat))
                    * COS(RADIANS($request->start_lng) - RADIANS(lng))
                    + SIN(RADIANS($request->start_lat))
                    * SIN(RADIANS(lat)))) AS distance")
            )->first();

        if (isset($provider)) {
            $percent            = $provider->user_type . '_percent';
            $provider_percent   = is_null($provider->admin_percent) ? (float) settings($percent) : (float) $provider->admin_percent;

            $order->update([
                'status'         => 'has_provider',
                'provider_id'    => $provider->id,
                'provider_name'  => $provider->full_name,
                'provider_phone' => $provider->phone,
                'provider_lat'   => $provider->lat,
                'provider_lng'   => $provider->lng,
                'provider_debt'  => (float) $order->total_after_promo * $provider_percent / 100,
            ]);

            #sent notify to provider
            /*$lang = $provider->lang == 'en' ? 'en' : 'ar';
            $msg  = [
                'title_ar'    => 'لديك طلب جديد برقم :' . $order->id,
                'title_en'    => 'You have a new Order No : ' . $order->id,
            ];
            $message = $msg['title_' . $lang];
            send_notify($provider->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
            foreach ($provider->devices as $device) {
                $device_id   = $device->device_id;
                if (!is_null($device_id)) send_one_signal($message, $device_id, '', $provider->user_type, $order->id);
            }*/

            $lang = $provider->lang == 'en' ? 'en' : 'ar';
            $msg  = [
                'title_ar'    => 'لديك طلب جديد برقم :' . $order->id,
                'title_en'    => 'You have a new Order No : ' . $order->id,
            ];
            $message = $msg['title_' . $lang];
            $data    = ['title' => settings('site_name'), 'body' => $message];
            send_notify($provider->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
            foreach (Device::whereUserId($provider->id)->get() as $device) {
                $device_id = $device->device_id;
                //if (!is_null($device_id)) send_one_signal($message, $device_id);
                if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
            }
        }

        #sent notify to user
        /*$lang = $user->lang == 'en' ? 'en' : 'ar';
        $msg  = [
            'title_ar'    => 'عزيزي العميل تم ارسال طلبك برقم :' . $order->id,
            'title_en'    => 'Your Order No : ' . $order->id . ' is sent',
        ];
        $message = $msg['title_' . $lang];
        send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
        foreach ($user->devices as $device) {
            $device_id   = $device->device_id;
            if (!is_null($device_id)) send_one_signal($message, $device_id, '', $user->user_type, $order->id);
        }*/

        if(isset($user)) {
            $lang = $user->lang == 'en' ? 'en' : 'ar';
            $msg  = [
                'title_ar'    => 'عزيزي العميل تم ارسال طلبك برقم :' . $order->id,
                'title_en'    => 'Your Order No : ' . $order->id . ' is sent',
            ];
            $message = $msg['title_' . $lang];
            $data    = ['title' => settings('site_name'), 'body' => $message];
            send_notify($user->id, $msg['title_ar'], $msg['title_en'], $order->id, 'new');
            foreach (Device::whereUserId($user->id)->get() as $device) {
                $device_id = $device->device_id;
                //if (!is_null($device_id)) send_one_signal($message, $device_id);
                if (!is_null($device_id)) send_fcm_to_app($device_id, $data);
            }
        }

        #send fcm to provider
        $tokens = Device::whereHas('user', function($q){
            return $q->where('user_type', 'admin');
        })->where('device_type', 'web')->pluck('device_id')->toArray();
        foreach ($tokens as $token){
            Send_FCM_Badge_naitve(['title' => 'طلب جديد', 'msg' => 'هناك طلب جديد'], $token);
        }

        #success response
        return api_response(1, trans('api.save'), new orderResource($order));
    }

    #show all orders
    public function api_showAllOrders(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|exists:users,api_token',
            'status'    => 'nullable|in:new,in_way,refused,finish',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $user = User::where('api_token', $request->api_token)->first();
        $request->request->add([ 'user_id'  => isset($user) ? $user->id : 0 ]);

        $orders = Order::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
        if (!empty($request->status)) $orders = Order::where('user_id', $request->user_id)->where('status', $request->status)->orderBy('id', 'desc')->get();

        #success response
        return api_response(1, trans('api.send'), orderResource::collection($orders));
    }

    #show order
    public function api_showOrder(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'order_id'     => 'required',
            'order_number' => 'nullable',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $user = User::where('api_token', $request->api_token)->first();
        $request->request->add([ 'user_id'  => isset($user) ? $user->id : 0 ]);

        $order = Order::where('id', $request->order_id)->orWhere('order_number', $request->order_number)->first();

        #success response
        return api_response(1, trans('api.save'), isset($order) ? new orderResource($order) : []);
    }

    /*
    |----------------------------------------------------|
    |----------------------------------------------------|
    |         update provider location Start             |
    |----------------------------------------------------|
    |----------------------------------------------------|
    */

    public function update_location(Request $request)
    {
        /** Validate Request **/
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'lat'       => 'required',
            'lng'       => 'required',
        ]);


        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        /** Update User's Device_id **/
        $user = User::whereId($request->user_id)->first();
        $user->update($request->except(['lang', 'user_id']));

        #success response
        return api_response(1, trans('api.save'));
    }

    /*
    |----------------------------------------------------|
    |----------------------------------------------------|
    |                 get address Start                  |
    |----------------------------------------------------|
    |----------------------------------------------------|
    */

    public function get_address(Request $request)
    {
        /** Validate Request **/
        $validator = Validator::make($request->all(), [
            'lat'       => 'required',
            'lng'       => 'required',
        ]);


        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        /** Update User's Device_id **/
        $address = get_address($request->lat, $request->lng);
        if($address) {
            return api_response(1, trans('api.send'), $address);

        } else {
            return api_response(1, trans('api.save'), '');
        }


    }
}
