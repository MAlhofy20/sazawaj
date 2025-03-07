<?php

#Models
use App\Models\Admin_report;
use App\Models\Visitor;
use App\Models\Country;
use App\Models\User_time;
use App\Models\Device;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Promo_code;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Cart;
use App\Models\Service;
use App\Models\Service_offer;
use App\Models\Section;
use App\Models\Section_static;
use App\Models\Social;
use App\Models\Not_now_offer;
use App\Models\Order;
use App\Models\Rate;
use App\Models\Room;
use App\Models\Room_chat;
use App\Models\City_delivery;
use App\Models\Favourite;
use App\Models\Order_time_static;
use App\Models\Service_option;
use App\Models\User_time_static;
use App\Models\User_block_list;
use App\Models\User;
#packages
use Carbon\Carbon;
#vendor files
use Illuminate\Support\Facades\App;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                  new fcm Helper Start              |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function base64UrlEncode($text)
{
    return str_replace(
        ['+', '/', '='],
        ['-', '_', ''],
        base64_encode($text)
    );
}

function genrateFireBaseAccessToken()
{
    $authConfigString = url('/fcm.json');

    // Read service account details
    $authConfigString = file_get_contents($authConfigString);

    // Parse service account details
    $authConfig = json_decode($authConfigString);

    // Read private key from service account details
    $secret = openssl_get_privatekey($authConfig->private_key);

    // Create the token header
    $header = json_encode([
        'typ' => 'JWT',
        'alg' => 'RS256'
    ]);

    // Get seconds since 1 January 1970
    $time = time();

    // Allow 1 minute time deviation between client en server (not sure if this is necessary)
    $start = $time - 60;
    $end = $start + 3600;

    // Create payload
    $payload = json_encode([
        "iss" => $authConfig->client_email,
        "scope" => "https://www.googleapis.com/auth/firebase.messaging",
        "aud" => "https://oauth2.googleapis.com/token",
        "exp" => $end,
        "iat" => $start
    ]);

    // Encode Header
    $base64UrlHeader = base64UrlEncode($header);

    // Encode Payload
    $base64UrlPayload = base64UrlEncode($payload);

    // Create Signature Hash
    $result = openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);

    // Encode Signature to Base64Url String
    $base64UrlSignature = base64UrlEncode($signature);

    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    //-----Request token, with an http post request------
    $options = array('http' => array(
        'method'  => 'POST',
        'content' => 'grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&assertion=' . $jwt,
        'header'  => "Content-Type: application/x-www-form-urlencoded"
    ));
    $context  = stream_context_create($options);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&assertion=' . $jwt);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/x-www-form-urlencoded",
    ]);
    $responseText = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
        exit;
    }
    curl_close($ch);
    $response = json_decode($responseText);

    $response = json_decode($responseText);
    return isset($response->access_token) ? $response->access_token : '';
}

function sendFCMNotificationToWeb($fcmToken = null, $data = [], $url = '')
{
    $projectId = 'sazawaj-5dd68';
    $accessToken = genrateFireBaseAccessToken();

    $title      = isset($data['title']) ? $data['title'] : settings('site_name');
    $body       = isset($data['body']) ? $data['body'] : 'اشعار جديد';
    $action_url = !is_null($url) ? $url : url('/');

    $message = [
        "message" => [
            "token" => $fcmToken,  // تأكد من إرسال الإشعار إلى جهاز معين عبر FCM Token
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => [
                "action_url" => $action_url,
            ],
            // القسم الخاص بالويب (Web Push)
            "webpush" => [
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                    "icon" => "icon_url", // يمكنك إضافة أيقونة هنا
                ],
                "data" => [
                    "action_url" => $action_url,
                    "click_action" => 'TOP_STORY_ACTIVITY',  // هنا يمكنك وضع الـ click_action الخاص بالويب
                ]
            ]
        ]
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Authorization: Bearer $accessToken\r\n" .
                "Content-Type: application/json\r\n",
            'content' => json_encode($message),
            'ignore_errors' => true,
        ]
    ];

    $context = stream_context_create($options);
    function sendNotification($projectId, $accessToken, $message)
    {
        $url = "https://fcm.googleapis.com/v1/projects/$projectId/messages:send";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json",
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
            exit;
        }

        curl_close($ch);

        return $response;
    }

    // Example usage:
    $message = [
        "message" => [
            "token" => $fcmToken,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => [
                "action_url" => $action_url,
            ],
        ],
    ];

    $response = sendNotification($projectId, $accessToken, $message);

    // Decode the JSON response:
    $responseDecoded = json_decode($response, true);

    if (isset($responseDecoded['name'])) {
        echo "Notification sent successfully: " . $responseDecoded['name'];
    } else {
        echo "Failed to send notification. Response: " . $response;
    }


    Log::info(['token' => $fcmToken, 'response' => $response]);
    return true;
}

function sendFCMNotificationToFLUTTER($fcmToken = null, $data = [], $click_action = 'FLUTTER_NOTIFICATION_CLICK')
{
    $projectId = 'sazawaj-5dd68';
    $accessToken = genrateFireBaseAccessToken();

    $title = isset($data['title']) ? $data['title'] : settings('site_name');
    $body  = isset($data['body']) ? $data['body'] : 'اشعار جديد';

    // بناء البيانات لإرسالها
    $message = [
        "message" => [
            "token" => $fcmToken,  // إرسال الإشعار إلى جهاز معين عبر FCM Token
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => [
                "order_id" => isset($data['order_id']) ? $data['order_id'] : '0',
                //"click_action" => $click_action,
            ],
            "android" => [
                "notification" => [
                    "body" => $body,
                ],
                "data" => [
                    "click_action" => $click_action,  // تفعيل click_action على Android
                ]
            ],
            "apns" => [
                "payload" => [
                    "aps" => [
                        "category" => "NEW_MESSAGE_CATEGORY"
                    ]
                ]
            ]
        ]
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Authorization: Bearer $accessToken\r\n" .
                "Content-Type: application/json\r\n",
            'content' => json_encode($message), // تأكد من إرسال المتغير $message
            'ignore_errors' => true,
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents("https://fcm.googleapis.com/v1/projects/$projectId/messages:send", false, $context);
    $response = json_decode($result);

    Log::info(['token' => $fcmToken, 'response' => $response]);
    return true;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                    new fcm Helper end              |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function agoraApi()
{
    // Set your Customer ID and Customer Secret
    $customerID = '3b056185db5c42d79f86702049cc8a96';
    $customerSecret = '9a8d7aa30ce546b9a64ba9a28d3224ab';

    // Base64 encode the credentials
    $authHeader = base64_encode("$customerID:$customerSecret");

    // Agora API endpoint (example: get project list)
    $url = 'https://api.agora.io/dev/v1/projects';

    // Set the headers for the request
    $options = [
        'http' => [
            'method'  => 'GET',
            'header'  => "Authorization: Basic $authHeader\r\n" .
                "Content-Type: application/json\r\n"
        ]
    ];

    // Create a stream context
    $context = stream_context_create($options);

    // Fetch the response
    $response = file_get_contents($url, false, $context);

    dd($response);
    // Check for errors
    if ($response === FALSE) {
        echo 'Error: Failed to fetch data from the API.';
    } else {
        // Output the API response
        echo $response;
    }
}

function getFavCount()
{
    $fav_count = (int) Favourite::where('user_id', auth()->id())->count();

    return 2 - $fav_count;
}

function checkUserPackage($user_id = '')
{
    $user  = User::whereId($user_id)->first();
    $user  = !isset($user) && auth()->check() ? auth()->user() : User::whereId($user_id)->first();
    $check = (isset($user) && $user->gender == 'female')
        ||
        (isset($user) && !empty($user->package_end_date) && !Carbon::parse($user->package_end_date)->isPast());

    return $check;
}

function getVisitorData($user_id, $to_id, $field = 'updated_at')
{
    $data  = Visitor::where('user_id', $user_id)->where('to_id', $to_id)->latest()->first();

    return isset($data) ? $data->$field : '';
}

function getBlockedData($user_id, $to_id, $field = 'updated_at')
{
    $data  = User_block_list::where('user_id', $user_id)->where('to_id', $to_id)->latest()->first();

    return isset($data) ? $data->$field : '';
}

function getFavouriteData($user_id, $to_id, $field = 'updated_at')
{
    $data  = Favourite::where('user_id', $user_id)->where('to_id', $to_id)->latest()->first();

    return isset($data) ? $data->$field : '';
}

function generateTimeArray($startTime, $endTime, $interval = '15 minutes')
{
    $start = new DateTime($startTime);
    $end = new DateTime($endTime);
    //$end = $end->modify('+1 second'); // لضمان تضمين نهاية الوقت

    $times = [];
    $current = $start;

    while ($current <= $end) {
        $times[] = $current->format('H:i');
        $current = $current->modify('+' . $interval);
    }

    return $times;
}

function checkIdCode()
{
    foreach (Order::whereNull('id_code')->get() as $order) {
        $order->update(['id_code' => substr($order->id_number, 0, 1)]);
    }
}

function checkOrderTime()
{
    $orders = Order::where('status', 'current')->whereDate('date', '<=', Carbon::now())->get();
    foreach ($orders as $order) {
        if (Carbon::parse($order->date . $order->time)->addMinutes((int) $order->amount)->isPast()) {
            $order->update(['status' => 'finish']);
        }
    }
}

function get_address($lat, $lng)
{
    $url    = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDl02ktqMdvzEwH-_oa7RREoI8Gr-6c9eQ&language=ar&latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';
    $json   = @file_get_contents($url);
    $data   = json_decode($json);
    $status = $data->status;
    if ($status == "OK") {
        return isset($data->results[1]) ? $data->results[1]->formatted_address : '';
    } else {
        return false;
    }
}

#show employees today times
function show_times($provider_id, $date, $duration)
{
    $date       = Carbon::parse($date)->format('Y-m-d');
    $saler      = User::whereId($provider_id)->first();
    $start      = Carbon::parse($date . $saler->start_time);
    $startHFormat = Carbon::parse($start)->format('H:i:s');
    $end        = Carbon::parse($date . $saler->end_time);
    $endHFormat = Carbon::parse($end)->format('H:i:s');
    $duration   = (int) $duration;
    //dd(Carbon::parse($date), $start, $startHFormat, $notAllowedTimes);
    $data = [];
    foreach (generateTimeRangeWithDate($startHFormat, $endHFormat, $duration, $date) as $item) {
        $date = isset($item['date']) ? $item['date'] : $date;
        $time = isset($item['time']) ? $item['time'] : $startHFormat;

        if (Carbon::parse($date . $time)->isPast()) continue;

        $new = [
            'date'           => $date,
            'time'           => Carbon::parse($time)->format('H:i:s'),
            'time_format'    => Carbon::parse($time)->format('h:i a'),
            'time_to'        => Carbon::parse($time)->addMinutes($duration)->format('H:i:s'),
            'time_to_format' => Carbon::parse($time)->addMinutes($duration)->format('h:i a'),
            'active'         => true,
            'is_selected'    => false
        ];
        array_push($data, $new);
    }

    return $data;
}

function check_times($provider_id, $date, $startHFormat, $endHFormat, $duration, $count)
{
    $notAllowedTimes = User_time_static::whereUserId($provider_id)
        ->where('count', $count)
        ->whereDate('date', Carbon::parse($date))
        ->pluck('time')
        ->toArray();

    //dd(in_array(Carbon::parse('08:00 pm')->format('H:i:s'), $notAllowedTimes));
    $date       = Carbon::parse($date)->format('Y-m-d');
    $start      = Carbon::parse($startHFormat)->format('H:i:s');
    $end        = Carbon::parse($endHFormat)->format('H:i:s');
    $duration   = (int) $duration;
    //dd(Carbon::parse($date), $start, $startHFormat, $notAllowedTimes);
    foreach (generateTimeRangeWithDate($start, $end, $duration, $date) as $item) {
        $date = isset($item['date']) ? $item['date'] : $date;
        $time = isset($item['time']) ? $item['time'] : $startHFormat;
        $time_carbon = Carbon::parse($date . $time);

        $orders = Order_time_static::where('provider_id', $provider_id)
            ->where('count', $count)
            ->whereDate('date', $date)
            ->whereTime('time', $time)
            ->count();

        if ($orders > 0 || $time_carbon->isPast() || in_array($time, $notAllowedTimes))
            return false;

        return true;
    }
}

// function show_times($saler_id, $date, $duration)
// {
//     $notAllowedTimes = User_time::whereUserId($saler_id)->whereDate('date', Carbon::parse($date))->pluck('time')->toArray();
//     //dd(in_array(Carbon::parse('08:00 pm')->format('H:i:s'), $notAllowedTimes));
//     $date       = Carbon::parse($date)->format('Y-m-d');
//     $saler      = User::whereId($saler_id)->first();
//     $start      = Carbon::parse($date . $saler->start_time);
//     $startHFormat = Carbon::parse($start)->format('H:i:s');
//     $end        = Carbon::parse($date . $saler->end_time);
//     $duration   = (int) $duration;
//     //dd(Carbon::parse($date), $start, $startHFormat, $notAllowedTimes);
//     $data = [];
//     do {
//         $order_id   = 0;
//         $active     = true;
//         $orders     = Order::where('provider_id', $saler_id)->whereDate('date', $date)->whereTime('time', $start)->whereNotIn('status', ['refused'])->count();
//         //if ($orders > 0 || $start->isPast()) //$active = false;
//         if ($orders > 0 || $start->isPast() || in_array($startHFormat, $notAllowedTimes)) {
//             //dd(Carbon::parse($date), $start, $startHFormat, $notAllowedTimes);
//             $start = Carbon::parse($start)->addMinutes($duration);
//             $startHFormat = Carbon::parse($start)->format('H:i:s');
//             continue;
//         }

//         $new    = ['date' => $date, 'time' => Carbon::parse($start)->format('H:i:s'), 'time_format' => Carbon::parse($start)->format('h:i a'), 'time_to' => Carbon::parse($start)->addMinutes($duration)->format('H:i:s'), 'time_to_format' => Carbon::parse($start)->addMinutes($duration)->format('h:i a'), 'active' => $active, 'is_selected' => false,];
//         array_push($data, $new);
//         $start = Carbon::parse($start)->addMinutes($duration);
//         $startHFormat = Carbon::parse($start)->format('H:i:s');
//     } while (Carbon::parse($start)->lessThan($end));

//     return $data;
// }

// function show_times()
// {
//     $start      = Carbon::parse(settings('start_time'));
//     $end        = Carbon::parse(settings('end_time'));
//     $duration   = 30;
//     //dd($date, $saler, $start, $end, $duration);
//     $data       = [];
//     do {
//         $active     = true;
//         $new    = ['time' => Carbon::parse($start)->format('H:i:s'), 'time_format' => Carbon::parse($start)->format('h:i a'), 'time_to' => Carbon::parse($start)->addMinutes($duration)->format('H:i:s'), 'time_to_format' => Carbon::parse($start)->addMinutes($duration)->format('h:i a'), 'active' => $active, 'is_selected' => false,];
//         array_push($data, $new);
//         $start = Carbon::parse($start)->addMinutes($duration);
//     } while (Carbon::parse($start)->lessThan($end));

//     return $data;
// }

function update_location($user_id = 0)
{
    #get orders
    if ($user_id > 0) {
        $orders = Order::where('provider_id', $user_id)->whereNotIn('status', ['finish', 'cancel', 'refused', 'new'])->get();
        $user   = User::whereId($user_id)->first();
    } else {
        $orders = Order::whereNotIn('status', ['finish', 'cancel', 'refused', 'new'])->get();
    }

    #data
    $lat    = isset($user) && !empty($user->lat) ? (float) $user->lat : 24.774265;
    $lng    = isset($user) && !empty($user->lng) ? (float) $user->lng : 46.738586;

    #update order data
    foreach ($orders as $order) {
        $order->update(['user_distance' => (float)get_distance($lat, $lng, $order->lat, $order->lng)]);
    }
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 awtTrans Helper Start              |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#Using to solve a problem at awtTrans()
function Translate($text)
{
    return $text;
    // $api  = 'trnsl.1.1.20190807T134850Z.8bb6a23ccc48e664.a19f759906f9bb12508c3f0db1c742f281aa8468';
    // $url = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key=' . $api
    //     . '&lang=ar' . '-' . $lang . '&text=' . urlencode($text));
    // $json = json_decode($url);
    // return $json->text[0];
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|               Room & chat Helper Start             |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function last_room_chat($room_id)
{
    $room  = Room::whereId($room_id)->first();
    if ($room->chats_desc->count() > 0) {
        $last_chat  = $room->chats_desc->first();
        $data = [
            'sender_id'    =>  $last_chat->from_id,
            'last_message' =>  $last_chat->type != 'file' ? (string)  $last_chat->message : url('' . $last_chat->message),
            'type'         =>  $last_chat->type,
            'duration'     =>  Carbon::parse($last_chat->created_at)->diffForHumans(),
            'duration_format' =>  Carbon::parse($last_chat->created_at)->format('Y-m-d'),
            'date'         =>  date('Y-m-d', strtotime($last_chat->created_at)),
        ];
    } else {
        $data = [
            'sender_id'    =>  0,
            'last_message' =>  '',
            'type'         =>  'text',
            'duration'     =>  Carbon::now()->diffForHumans(),
            'date'         =>  Carbon::now()->format('Y-m-d'),
        ];
    }

    return $data;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|               Permission Helper Start              |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#check if user has Permission
function hasPermission($routeName)
{
    if (Auth::guest()) return false;
    $role = Role::whereId(Auth::user()->role_id)->first();
    if (!isset($role)) return false;

    $permissions = Permission::whereRoleId(Auth::user()->role_id)->pluck('name')->toArray();
    return in_array($routeName, $permissions);
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 path Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#Dashboard path
function dashboard_path()
{
    return url('/dashboard');
}

#Site path
function site_path()
{
    return url('/site');
}

function json_path()
{
    return url('/json');
}

#static path
function static_path()
{
    return url('/static');
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 phone Helper Start                 |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function convertToArabicNumbers($number)
{
    $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    return str_replace(range(0, 9), $arabicNumbers, $number);
}

#convert arabic number to english format
function convert_to_english($string)
{
    $newNumbers = range(0, 9);
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $string =  str_replace($arabic, $newNumbers, $string);
    return $string;
}

#convert phone to soudi arabia format
function convert_phone_to_international_format($phone, $code = '966')
{
    $withoutZero  = ltrim(convert_to_english($phone), '0');
    $filter_zero  = ltrim($withoutZero, $code . '0');
    $filter_code  = ltrim($filter_zero, $code);
    $full_phone   = $code . $filter_code;
    return $full_phone;
}


/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 Image Helper Start                 |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#upload multi-part image
function upload_image($photo, $dir)
{
    $dir = public_path($dir); // Ensure correct full path

    \Log::info('Uploading image: ' . $photo->getClientOriginalName());
    \Log::info('Corrected Target Directory: ' . $dir);

    if (!is_dir($dir)) {
        mkdir($dir, 0775, true); // Ensure the folder exists
        \Log::info('Created directory: ' . $dir);
    }

    $name = date('d-m-y') . time() . rand() . '.' . $photo->getClientOriginalExtension();
    $photo->move($dir, $name); // Move to correct folder

    return '/' . trim(str_replace(public_path(), '', $dir), '/') . '/' . $name;
}



function get_rand_code($order_id)
{
    start:
    $api_token = 'QN' . date('dmy') . rand('11111111', '99999999');
    $order     = Order::where('id', '!=', $order_id)->where('api_token', '$api_token')->first();
    if (isset($order)) goto start;
    return $api_token;
}

#upload image base64
function save_image($base64_img, $img_name, $path)
{
    $image = base64_decode($base64_img);
    $pathh = $_SERVER['DOCUMENT_ROOT'] . '/' . $path . '/' . $img_name . '.png';
    file_put_contents($pathh, $image);
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                   Mail Helper Start                |
|----------------------------------------------------|
|----------------------------------------------------|
*/

/*

function send_mail_php($email, $msg, $title = '(هذا البريد آلي ولا يتطلّب الرد)')
{
    // In case any of our lines are larger than 70 characters, we should use wordwrap()
    $message = wordwrap($msg, 70, "\r\n");

    // Send
    mail($email, $title, $message);
}

function send_mail_html($email, $msg, $from = 'info@hr.sa', $title = '(هذا البريد آلي ولا يتطلّب الرد)')
{
    // In case any of our lines are larger than 70 characters, we should use wordwrap()
    $message = wordwrap($msg, 70, "\r\n");

    // To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';

    // Additional headers
    //$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
    //$headers[] = 'From: HR <' . $from . '>';
    //$headers[] = 'Cc: birthdayarchive@example.com';
    //$headers[] = 'Bcc: birthdaycheck@example.com';

    // Send
    mail($email, $title, $message, implode("\r\n", $headers));
}

*/

function send_mail_php($email, $msg, $title = '(هذا البريد آلي ولا يتطلّب الرد)')
{
    // تحميل مكتبة PHPMailer
    //require 'vendor/autoload.php';

    // إعداد PHPMailer
    $mail = new PHPMailer(true);
    try {
        // إعدادات SMTP من ملف .env
        $mail->isSMTP();                                           // استخدام SMTP
        $mail->Host       = env('MAIL_HOST');                        // جلب الخادم من .env
        $mail->SMTPAuth   = true;                                    // تمكين المصادقة
        $mail->Username   = env('MAIL_USERNAME');                    // جلب اسم المستخدم (البريد الإلكتروني) من .env
        $mail->Password   = env('MAIL_PASSWORD');                    // جلب كلمة المرور من .env
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // استخدام التشفير STARTTLS
        $mail->Port       = env('MAIL_PORT', 587);                   // جلب المنفذ من .env (587 هو المنفذ الافتراضي لـ TLS)

        // تعيين الترميز UTF-8
        $mail->CharSet = 'UTF-8';

        // المستلمين
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'اسم الشركة')); // من هو البريد
        $mail->addAddress($email);                                  // إضافة المستلم

        // تعيين العنوان بشكل صحيح باستخدام mb_encode_mimeheader
        $mail->Subject = mb_encode_mimeheader($title, 'UTF-8');     // العنوان مع الترميز

        // المحتوى (التأكد من تضمين HTML فقط هنا)
        $mail->isHTML(true);                                        // إرسال البريد كـ HTML
        $mail->Body    = '
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . $title . '</title>
        </head>
        <body dir="rtl" style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
            <table style="width: 100%; background-color: #ffffff; border-radius: 8px; padding: 20px;">
                <tr>
                    <td style="text-align: center;">
                        <img src="https://moshop.xyz/public/images/setting/10-01-25173651546353724979.png" alt="شعار الموقع" style="max-width: 200px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; text-align: center;">
                        <h2>' . $title . '</h2>
                        <p>' . $msg . '</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 20px;">
                        <a href="https://yourwebsite.com" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">زيارة الموقع</a>
                    </td>
                </tr>
            </table>
            <footer style="text-align: center; padding-top: 20px;">
                <p>© ' . date('Y') . ' موقعك | جميع الحقوق محفوظة.</p>
            </footer>
        </body>
        </html>';


        // إرسال البريد
        $mail->send();
        echo 'تم إرسال البريد بنجاح';
    } catch (Exception $e) {
        echo "لم يتم إرسال البريد. خطأ: {$mail->ErrorInfo}";
    }
}

function send_mail_html($email, $msg, $from = 'info@pifreelancer.com', $title = 'سعودي زواج')
{
    // تحميل مكتبة PHPMailer
    //require 'vendor/autoload.php';

    // إعداد PHPMailer
    $mail = new PHPMailer(true);
    try {
        // إعدادات SMTP من ملف .env
        $mail->isSMTP();                                           // استخدام SMTP
        $mail->Host       = env('MAIL_HOST');                        // جلب الخادم من .env
        $mail->SMTPAuth   = true;                                    // تمكين المصادقة
        $mail->Username   = env('MAIL_USERNAME');                    // جلب اسم المستخدم (البريد الإلكتروني) من .env
        $mail->Password   = env('MAIL_PASSWORD');                    // جلب كلمة المرور من .env
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // استخدام التشفير STARTTLS
        $mail->Port       = env('MAIL_PORT', 587);                   // جلب المنفذ من .env (587 هو المنفذ الافتراضي لـ TLS)

        // تعيين الترميز UTF-8
        $mail->CharSet = 'UTF-8';

        // المستلمين
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'اسم الشركة'));  // من هو البريد
        $mail->addAddress($email);                                  // إضافة المستلم

        // تعيين العنوان بشكل صحيح باستخدام mb_encode_mimeheader
        $mail->Subject = mb_encode_mimeheader($title, 'UTF-8');     // العنوان مع الترميز

        // المحتوى (التأكد من تضمين HTML فقط هنا)
        $mail->isHTML(true);                                        // إرسال البريد كـ HTML
        $mail->Body    = '
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . $title . '</title>
        </head>
        <body dir="rtl" style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
            <table style="width: 100%; background-color: #ffffff; border-radius: 8px; padding: 20px;">
                <tr>
                    <td style="text-align: center;">
                        <img src="https://moshop.xyz/public/images/setting/10-01-25173651546353724979.png" alt="شعار الموقع" style="max-width: 200px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; text-align: center;">
                        <h2>' . "مرحبا" . '</h2>
                        <p>' . $msg . '</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 20px;">
                        <a href="https://moshop.xyz" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">زيارة الموقع</a>
                    </td>
                </tr>
            </table>
            <footer style="text-align: center; padding-top: 20px;">
                <p>© ' . date('Y') . ' سعودي زواج | جميع الحقوق محفوظة.</p>
            </footer>
        </body>
        </html>'; // الرسالة مع الترميز

        // إرسال البريد
        $mail->send();
        echo 'تم إرسال البريد بنجاح';
    } catch (Exception $e) {
        echo "لم يتم إرسال البريد. خطأ: {$mail->ErrorInfo}";
    }
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 SMS Helper Start                   |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function send_to_whatsapp($number, $message, $media_url = '', $filename = '')
{
    $url    = 'https://prowhats.app/api/send.php';
    $myvars = 'type=text' . '&number=' . $number . '&message=' . $message . '&instance_id=61A4C674E801E&access_token=d9a8212bd9b4bce2095a54711d9d6876';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    if ($response) dd($response);

    return false;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 SMS Helper Start                   |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function sms_zain($myphone, $active, $type = 'code')
{

    $phones = $myphone;      // Should be like 966530007039

    if ($type == 'code') $msg = urlencode('كود التفعيل :  ' . $active . '   ');
    else $msg = urlencode($active . '   ');


    $link = "https://www.zain.im/index.php/api/sendsms/?user=padel&pass=1q2w3e4r&to=$phones&message=$msg&sender=es-co";
    /*
     *  return  para      can be     [ json , xml , text ]
     *  username  :  your username on safa-sms
     *  passwpord :  your password on safa-sms
     *  sender    :  your sender name
     *  numbers   :  list numbers delimited by ,     like    966530007039,966530007039,966530007039
     *  message   :  your message text
     */

    /*
     * 100   Success Number
     */

    if (function_exists('curl_init')) {
        $curl = @curl_init($link);
        @curl_setopt($curl, CURLOPT_HEADER, FALSE);
        @curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        @curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $source = @curl_exec($curl);
        @curl_close($curl);
        if ($source) {
            return $source;
        } else {
            return @file_get_contents($link);
        }
    } else {
        return @file_get_contents($link);
    }
}

function sms_zain_auth($myphone, $active, $type = 'code')
{

    $phones = $myphone;      // Should be like 966530007039

    if ($type == 'code') $msg = urlencode('كود التفعيل :  ' . $active . '   ');
    else $msg = urlencode($active . '   ');


    $link = "https://www.zain.im/index.php/api/sendsms/?user=padel&pass=1q2w3e4r&to=$phones&message=$msg&sender=es-co";
    /*
     *  return  para      can be     [ json , xml , text ]
     *  username  :  your username on safa-sms
     *  passwpord :  your password on safa-sms
     *  sender    :  your sender name
     *  numbers   :  list numbers delimited by ,     like    966530007039,966530007039,966530007039
     *  message   :  your message text
     */

    /*
     * 100   Success Number
     */

    if (function_exists('curl_init')) {
        $curl = @curl_init($link);
        @curl_setopt($curl, CURLOPT_HEADER, FALSE);
        @curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        @curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $source = @curl_exec($curl);
        @curl_close($curl);
        if ($source) {
            return $source;
        } else {
            return @file_get_contents($link);
        }
    } else {
        return @file_get_contents($link);
    }
}

#send sms
function send_sms($phone, $msg, $package = 'zain')
{
    $data = [
        'username' => 'fofo7070',
        'password' => '123456',
        'sender'   => 'es-co
        ',
    ];
    //$link = "https://www.zain.im/index.php/api/sendsms/?user=padel&pass=1q2w3e4r&to=$phones&message=$msg&sender=efadh.com";
    switch ($package) {
        case 'our_sms':
            send_sms_our_sms($phone, $msg, $data);
            break;
        case 'zain':
            send_sms_zain($phone, $msg, $data);
            break;
        case 'mobily':
            send_sms_mobily($phone, $msg, $data);
            break;
        case 'yammah':
            send_sms_yammah($phone, $msg, $data);
            break;
        case 'hisms':
            send_sms_hisms($phone, $msg, $data);
            break;
        default:
            return false;
    }
}

#our_sms package
function send_sms_our_sms($phone, $msg, $data)
{
    sleep(1);
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $text       = urlencode($msg);
    $to         = '+' . $phone;
    // auth call
    //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=full";
    //لارجاع القيمه json
    $url = "http://www.oursms.net/api/sendsms.php?username=$username&password=$password&numbers=$to&message=$text&sender=$sender&unicode=E&return=json";
    // لارجاع القيمه xml
    //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=xml";
    // لارجاع القيمه string
    //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E";

    // Call API and get return message
    //fopen($url,"r");
    //return $url;
    $ret = file_get_contents($url);
    //echo nl2br($ret);
}

#zain package
function send_sms_zain($phone, $msg, $data)
{
    sleep(1);
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg . '   ');
    //$link = "https://www.zain.im/index.php/api/sendsms/?user=user&pass=123456&to=$phones&message=$msg&sender=sender";
    $link = "https://www.zain.im/index.php/api/sendsms/?user=$username&pass=$password&to=$to&message=$text&sender=$sender";

    /*
        *  return  para      can be     [ json , xml , text ]
        *  username  :  your username on safa-sms
        *  passwpord :  your password on safa-sms
        *  sender    :  your sender name
        *  numbers   :  list numbers delimited by ,     like    966530007039,966530007039,966530007039
        *  message   :  your message text
        */

    /*
        * 100   Success Number
        */

    if (function_exists('curl_init')) {
        $curl = @curl_init($link);
        @curl_setopt($curl, CURLOPT_HEADER, FALSE);
        @curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        @curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $source = @curl_exec($curl);
        @curl_close($curl);
        if ($source) {
            return $source;
        } else {
            return @file_get_contents($link);
        }
    } else {
        return @file_get_contents($link);
    }
}

#mobily package
function send_sms_mobily($phone, $msg, $data)
{
    sleep(1);
    $url        = 'http://api.yamamah.com/SendSMS';
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg);
    $sender     = urlencode($sender);
    $fields   = array(
        "Username"        => $username,
        "Password"        => $password,
        "Tagname"         => $sender,
        "Message"         => $text,
        "RecepientNumber" => $to,
    );
    $fields_string = json_encode($fields);
    //open connection
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        CURLOPT_POSTFIELDS => $fields_string
    ));

    $result = curl_exec($ch);
    curl_close($ch);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

#yammah package
function send_sms_yammah($phone, $msg, $data)
{
    sleep(1);
    $url        = 'api.yamamah.com/SendSMS';
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg);
    $fields = array(
        "Username" => $username,
        "Password" => $password,
        "Message" => $text,
        "RecepientNumber" => $to, //'00966'.ltrim($numbers,'0'),
        "ReplacementList" => "",
        "SendDateTime" => "0",
        "EnableDR" => False,
        "Tagname" => $sender,
        "VariableList" => "0"
    );

    $fields_string = json_encode($fields);

    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        CURLOPT_POSTFIELDS => $fields_string
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}

#hisms package
function send_sms_hisms($phone, $msg, $data)
{
    sleep(1);
    $url        = 'https://www.hisms.ws/api.php?send_sms&';
    $username   = $data['username'];
    $password   = $data['password'];
    $sender     = $data['sender'];
    $to         = $phone; // Should be like 966530007039
    $text       = urlencode($msg);
    $fields = [
        "username" => $username,
        "password" => $password,
        "numbers"  => $to,
        "sender"   => $sender,
        "message"  => $text,
    ];

    //open connection
    $ch = curl_init($url);
    curl_setopt_array(
        $ch,
        [
            CURLOPT_URL => $url . http_build_query($fields, null, '&'),
            CURLOPT_RETURNTRANSFER => true
        ]
    );

    $result = curl_exec($ch);
    curl_close($ch);
    // echo $result;
}

#alfa-cell
function send_alfa_cell($phone, $msg)
{

    $apiKey     = '';
    $sender     = '';
    $url        = 'https://www.alfa-cell.com/api/msgSend.php?apiKey=' . urlencode($apiKey) . '&numbers=' . urlencode($phone) . '&sender=' . urlencode($sender) . '&msg=' . urlencode($msg) . '&timeSend=0&dateSend=0&applicationType=68&domainName=aait.sa&msgId=15176';
    $json       = json_decode(file_get_contents($url), true);

    return $json;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|              Payment Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#HyperPay
function is_success($code)
{

    $arr = [
        '000.000.000',
        '000.000.100',
        '000.100.110',
        '000.100.111',
        '000.100.112',
        '000.300.000',
        '000.300.100',
        '000.300.101',
        '000.300.102',
        '000.600.000',
        '000.200.100'
    ];

    return in_array($code, $arr) ? true : false;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                  API Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#api response format
function api_response($key, $msg, $data = null, $anotherKey = [])
{
    $all_response['key']         = (int) $key;
    $all_response['msg']         = $msg;
    $all_response['show_image']  = (bool)   settings('show_image');
    // $all_response['whatsapp']    = (string) settings('whatsapp');
    // $all_response['facebook']    = (string) settings('facebook');
    // $all_response['twitter']     = (string) settings('twitter');
    // $all_response['instagram']   = (string) settings('instagram');
    // $all_response['linkedin']    = (string) settings('linkedin');
    // $all_response['maroof']      = (string) settings('maroof');
    $all_response['tawk_to']     = (string) settings('tawk_to');
    // $all_response['packaging']   = (float)  settings('packaging');
    if (!empty($anotherKey)) {
        foreach ($anotherKey as $key => $value) {
            $all_response[$key] = $value;
        }
    }
    if (!is_null($data)) $all_response['data'] = $data;
    return response()->json($all_response);
}

#set lang
function set_lang($lang)
{
    /** Set Site Lang **/
    $lang == 'en' ? App::setLocale('en') : App::setLocale('ar');
    /** Set Carbon Lang **/
    $lang == 'en' ? Carbon::setLocale('en') : Carbon::setLocale('ar');
}

#user status
function user_status($user)
{
    $status = 'active';
    //if ($user->confirm == 0) $status = 'non-confirm';
    if ($user->active == 0)  $status = 'non-active';
    if ($user->blocked == 1) $status = 'blocked';
    return $status;
}

#user rate
function user_rate($user_id)
{
    return (float) Rate::whereProviderId($user_id)->avg('rate');
}

#total_profit
function total_profit($user_id)
{
    $user = User::whereId($user_id)->first();
    $total = 0;
    if (isset($user)) {
        if ($user->user_type == 'provider') {
            $total = Order::whereDelegateId($user_id)->whereStatus('finish')->sum('delivery');
        } else {
            $total = Order::whereProviderId($user_id)->whereStatus('finish')->sum('total_after_promo');
        }
    }
    return $total;
}

#get_distance
function get_distance($latitudeFrom = 0, $longitudeFrom = 0, $latitudeTo = 0, $longitudeTo = 0, $earthRadius = 3959)
{
    //meter = 6371000,miles = 3959,km = $miles * 1.609344

    if ($latitudeFrom == 0 || $longitudeFrom == 0 || $latitudeTo == 0 || $longitudeTo == 0) return 0;

    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    $res   = ($angle * $earthRadius) * 1.609344; //convert from miles to km
    return (float) round($res);
}


function get_order_price($city_id, $city_to_id, $count = 1)
{
    $check = City_delivery::whereCityId($city_id)->whereCityToId($city_to_id)->first();
    if (!isset($check)) $check = City_delivery::create(['city_id' => $city_id, 'city_to_id' => $city_to_id, 'price' => 0]);
    return isset($check) ? $check->price * $count : 0;
}

function get_delivery($saler_id = null)
{
    $user     = User::whereId($saler_id)->first();
    $delivery = (float) settings('delivery');
    if (isset($user) && $user->has_delivary) {
        $delivery = (float) $user->delivary;
    }
    return $delivery;
}

function get_not_allow($saler_id = null, $user_id = null)
{
    $data['status']     = false;
    $data['total']      = 0;
    $data['duration']   = 0;

    if (!is_null($saler_id) && !is_null($user_id)) {
        $not_now = Not_now_offer::where('delete', '!=', '1')->whereUserId($user_id)->whereSalerId($saler_id)->first();
        if (isset($not_now)) {
            $total = $not_now->total - $not_now->current_total;
            $data['status']     = $total > 0 ? true : false;
            $data['total']      = $total > 0 ? $total : 0;
            $data['duration']   = $not_now->duration;
        }
    }
    return $data;
}

#order status
function order_status($status)
{
    if (App::getLocale() == 'en') {
        $order_status  = [
            "new"          => "In prograss",
            "current"      => "Current",
            // "in_way"       => "In Way",
            "finish"       => "Finished",
            "refused"      => "Canceled",
        ];
    } else {
        $order_status  = [
            "new"          => "في الانتظار",
            "current"      => "حجز حالي",
            // "in_way"       => "قيد التسليم",
            "finish"       => "حجز منتهي",
            "refused"      => "حجز ملغى",
        ];
    }
    return isset($order_status[$status]) ? $order_status[$status] : $order_status['new'];
}

#slider type
function slider_type($type)
{
    if (App::getLocale() == 'en') {
        $slider_type  = [
            "home"      => "home",
            "market"    => "market",
            "volunteer" => "volunteer",
            "services"  => "services",
        ];
    } else {
        $slider_type  = [
            "home"      => "الرئيسية",
            "market"    => "السوق الخيري",
            "volunteer" => "التبرع",
            "services"  => "خدمتنا",
        ];
    }
    return isset($slider_type[$type]) ? $slider_type[$type] : $slider_type['new'];
}

#order status
function get_status_map($status)
{
    $order_status  = [
        "refused"      => 0,
        "new"          => 1,
        "current"      => 1,
        "in_way"       => 2,
        "finish"       => 3,
    ];

    return [
        "refused"      => isset($order_status[$status]) && $order_status[$status] == 0,
        "new"          => isset($order_status[$status]) && $order_status[$status] >= 1,
        "current"      => isset($order_status[$status]) && $order_status[$status] >= 1,
        "in_way"       => isset($order_status[$status]) && $order_status[$status] >= 2,
        "finish"       => isset($order_status[$status]) && $order_status[$status] == 3,
    ];
}

#show section type
function show_section_type($type)
{
    $order_type  = [
        "doctor"     => "اطباء",
        "hospital"   => "مستشفيات",
        "lab"        => "معامل تحاليل",
        "static"     => "عرض معلومات"
    ];
    return isset($order_type[$type]) ? $order_type[$type] : 'عرض معلومات';
}

#show section type
function show_user_types()
{
    $user_types  = [
        "saler"    => "تاجر جملة",
        "market"   => "تاجر تجزئة",
    ];
    return $user_types;
}

#show section type
function show_user_type_value($key = 'doctor')
{
    $user_types  = [
        "doctor"     => "طبيب",
        "hospital"   => "مستشفى",
        "lab"        => "معمل تحاليل",
    ];
    return isset($user_types[$key]) ? $user_types[$key] : "طبيب";
}

#check user day
function check_user_day($day_id, $user_id = null)
{
    // $user_id = is_null($user_id) ? Auth::id() : $user_id;
    // $day     = User_day::whereUserId($user_id)->whereDayId($day_id)->first();
    // return isset($day);
}

#get service price
function get_service_price($service_id, $count = 1, $size_id = null, $option_id = null, $side_id = null)
{
    $service = Service::whereId($service_id)->first();
    $size    = Service_option::whereId($size_id)->first();
    $option  = Service_option::whereId($option_id)->first();
    $side    = Service_option::whereId($side_id)->first();

    if (!isset($size)) $size = Service_option::whereServiceId($service_id)->where('type', 'size')->first();

    $total = isset($size) ? (float) $size->price_with_value : (float) $service->price_with_value;
    $total = isset($option) ? (float) $option->price_with_value + $total : $total;
    $total = isset($side) ? (float) $side->price_with_value + $total : $total;

    return $total;
}

#check_cart
function check_cart($user_id = null)
{
    $carts = Cart::whereUserId($user_id)->get();

    foreach ($carts as $cart) {
        $service = Service::whereId($cart->service_id)->first();
        if ((float) $cart->count > (float) $service->amount) { // check current amount & price
            if ((float) $service->amount > 0) {
                $price   = get_service_price($service->id, (float) $service->amount);
                $cart->update([
                    'count' => (float) $service->amount,
                    'total' => (float) $service->amount * $price,
                ]);
            } else {
                $cart->delete();
            }
        } else { // check current price
            $price   = get_service_price($service->id, (float) $cart->count);
            $cart->update([
                'total' => (float) $cart->count * $price,
            ]);
        }
    }
}

#update user device
function update_device($user, $device_id, $device_type = null)
{
    Device::where('device_id', $device_id)->delete();
    Device::create(
        ['user_id' => $user->id, 'device_id' => $device_id, 'device_type' => $device_type]
    );
}

#send notify
function send_notify($to_id, $message_ar, $message_en, $url, $header = null, $order_id = null, $order_status = null)
{
    Notification::create([
        'to_id'        => $to_id,
        'header'       => $header,
        'message_ar'   => $message_ar,
        'message_en'   => $message_en,
        'type'         => is_null($order_id) ? 'notify' : 'order',
        'order_id'     => $order_id,
        'order_status' => $order_status,
        'seen'         => 0,
        'url'          => $url,
    ]);
}

#user unseen notification count
function user_notify_count($user_id = null)
{
    return Notification::unSeenMessage($user_id);
}

#check radar static
function check_radar_static($request = null)
{
    /** Get Data **/
    $lat = $request->lat;
    $lng = $request->lng;

    $query = Section_static::query();
    $query->where('user_id', $request->user_id);
    $query->having('distance', '<=', settings('section_distinse'))
        ->select(
            DB::raw("*,
                    (3959 * ACOS(COS(RADIANS($lat))
                    * COS(RADIANS(lat))
                    * COS(RADIANS($lng) - RADIANS(lng))
                    + SIN(RADIANS($lat))
                    * SIN(RADIANS(lat)))) AS distance")
        );
    $section = $query->first();

    return isset($section);
}

#check radar
function check_radar($request = null)
{
    /** Get Data **/
    $lat = $request->lat;
    $lng = $request->lng;

    $query = Section::query();
    $query->having('distance', '<=', settings('section_distinse'))
        ->select(
            DB::raw("*,
                    (3959 * ACOS(COS(RADIANS($lat))
                    * COS(RADIANS(lat))
                    * COS(RADIANS($lng) - RADIANS(lng))
                    + SIN(RADIANS($lat))
                    * SIN(RADIANS(lat)))) AS distance")
        );
    $section = $query->first();

    return isset($section);
}

function count_radar($request = null)
{
    /** Get Data **/
    $lat = $request->lat;
    $lng = $request->lng;

    $query = Section_static::query();
    $query->having('distance', '<=', settings('section_distinse'))
        ->select(
            DB::raw("*,
                    (3959 * ACOS(COS(RADIANS($lat))
                    * COS(RADIANS(lat))
                    * COS(RADIANS($lng) - RADIANS(lng))
                    + SIN(RADIANS($lat))
                    * SIN(RADIANS(lat)))) AS distance")
        );
    $sections = $query->get();

    return count($sections);
}

function first_radar($request = null)
{
    /** Get Data **/
    $lat = $request->lat;
    $lng = $request->lng;

    $query = Section_static::query();
    $query->having('distance', '<=', settings('section_distinse'))
        ->select(
            DB::raw("*,
                    (3959 * ACOS(COS(RADIANS($lat))
                    * COS(RADIANS(lat))
                    * COS(RADIANS($lng) - RADIANS(lng))
                    + SIN(RADIANS($lat))
                    * SIN(RADIANS(lat)))) AS distance")
        );
    $section = $query->first();

    return $section;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|            PromoCode Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#check promo code
function check_promo_code($user_id, $code)
{
    $promo = Promo_code::whereCode($code)->first();
    if (!isset($promo)) return 0; // wrong promoCode

    $used_by = is_null($promo->used_by) ? [] : json_decode($promo->used_by);
    if (in_array($user_id, $used_by) || $promo->status == 'invalid') return 0; // invalid promoCode

    return (float) $promo->discount;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                  FCM Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function send_fcm_to_app($token, $msg_data, $setBadge = 0)
{
    sendFCMNotificationToFLUTTER($token, $msg_data);
    return true;

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);

    $notificationBuilder = new PayloadNotificationBuilder($msg_data['title']);
    $notificationBuilder->setBody($msg_data['body'])
        ->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData($msg_data);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

    $downstreamResponse->numberSuccess();
    $downstreamResponse->numberFailure();
    $downstreamResponse->numberModification();
    //dd($downstreamResponse);
}

#send FCM
function Send_FCM_Badge_naitve($all_data, $token, $setBadge = 0)
{
    $priority = 'high'; // or 'normal'

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);
    $optionBuilder->setPriority($priority);
    $notificationBuilder = new PayloadNotificationBuilder($all_data['title']);
    $notificationBuilder->setBody($all_data['msg'])->setSound('default')->setClickAction('/site-orders/new');
    //$notificationBuilder->setBody($all_data['message'])->setSound('default')->setBadge($setBadge);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData($all_data);

    $data = $dataBuilder->build();
    //foreach (Device::where('device_type', 'web')->pluck('device_id')->toArray() as $token) {

    //dd($token, $option, $notification, $data);
    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

    $downstreamResponse->numberSuccess();
    $downstreamResponse->numberFailure();
    $downstreamResponse->numberModification();

    //dd($downstreamResponse);
}

#send FCM
function send_fcm($device_id, $data, $type, $setBadge = 0)
{
    $priority = 'high'; // or 'normal'
    // $action = 'FLUTTER_NOTIFICATION_CLICK';
    // if ($device->device_type == 'web') $action = '/';
    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);
    $optionBuilder->setPriority($priority);
    $notificationBuilder = new PayloadNotificationBuilder($data['title']);
    $notificationBuilder->setBody($data['body'])->setSound('default');
    //$notificationBuilder->setBody($data['message'])->setSound('default')->setBadge($setBadge)->setClickAction($action);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData($data);
    $data = $dataBuilder->build();

    if ($type == 'android') {
        $downstreamResponse = FCM::sendTo($token, $option, null, $data);
    } else {
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }

    $downstreamResponse->numberSuccess();
    $downstreamResponse->numberFailure();
    $downstreamResponse->numberModification();
}

/*function send_one_signal($notmessage, $tokens, $status = '', $user_type = 'client', $id = 0)
{
    $content = array(
        "en" => $notmessage
    );
    $token[] = $tokens;
    $fields = array(
        'app_id' => "01c1668a-1bad-4b77-afe9-1b1fa3cea93e",
        'android_channel_id' => "66eecf4b-19a4-4dfc-904c-868bb1e057fb",
        'include_player_ids' => $token,
        //'large_icon' => "https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png",
        'data' => array("foo" => "bar", "notificationType" => $status, "order_id" => $id, "order_status" => $user_type),
        "heading" => "headings",
        'contents' => $content,
        //'android_sound' => 'alert',
        "content_available" => true,
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic YjMyZmZmZGMtNDc5NS00MTc3LThiMmQtYzU3OWJmZDlhNTM0'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}*/

function send_one_signal($notmessage, $tokens, $status = '', $user_type = 'client', $id = 0)
{
    $content = array(
        "en" => $notmessage
    );
    $token[] = $tokens;
    $fields = array(
        'app_id' => "b58add32-0126-4cde-b1b1-3224646b6903",
        'include_player_ids' => $token,
        'data' => array("foo" => "bar", "notificationType" => $status, "order_id" => $id, "order_status" => $user_type),
        "heading" => "headings",

        'contents' => $content,
        "content_available" => true,
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic OTNlNzViM2UtNTI2OS00ZDFjLTgzMGItMWU2YTY2M2U4NWFm'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|            adminReport Helper Start                |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#store adminReport
function admin_report($desc)
{
    $text = 'قام المدير ' . Auth::user()->name . ' ب' . $desc;
    Admin_report::create(['desc' => $text]);
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                Youtube Helper Start                |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#get youtube embed link
function get_embed_link($youtubeUrl)
{
    // Extract id
    preg_match(
        "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",
        $youtubeUrl,
        $videoId
    );
    return $youtubeVideoId = isset($videoId[1]) ? 'https://www.youtube.com/embed/' . $videoId[1] : "";
}


/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 data Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#get value from settings DB
function settings($key)
{
    $setting = Setting::firstOrCreate(['key' => $key]);
    return $setting->value;
}

#get social links
function social($key)
{
    $social = Social::firstOrCreate(['key' => $key]);
    return $social->value;
}

#get users by (userType , orderBy , paginateCount)
function get_users_by($userType = 'client', $orderBy = 'desc', $paginateCount = 24)
{
    if ($paginateCount != 0)
        $users = User::where('user_type', $userType)->orderBy('id', $orderBy)->paginate($paginateCount);
    else
        $users = User::where('user_type', $userType)->orderBy('id', $orderBy)->get();

    return $users;
}

#get all countries
function get_countries($orderBy = 'title_ar')
{
    $countries = Country::orderBy($orderBy, 'asc')->get();
    return $countries;
}

#get all cars
function get_cars()
{
    $data = [
        'small' => awtTrans('سيارة خاصة'),
        'big'   => awtTrans('سيارة نقل'),
    ];
    return $data;
}


/*
|----------------------------------------------------|
|----------------------------------------------------|
|                  Arabic Helper Start               |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#convert from english day to arabic format
function day_to_arabic($day)
{
    $lang  = App::getLocale();
    $dayArray = [
        'Saturday'  => 'السبت',
        'saturday'  => 'السبت',
        'Sunday'    => 'الاحد',
        'sunday'    => 'الاحد',
        'Monday'    => 'الاثنين',
        'monday'    => 'الاثنين',
        'Tuesday'   => 'الثلاثاء',
        'tuesday'   => 'الثلاثاء',
        'Wednesday' => 'الاربعاء',
        'wednesday' => 'الاربعاء',
        'Thursday'  => 'الخميس',
        'thursday'  => 'الخميس',
        'Friday'    => 'الجمعة',
        'friday'    => 'الجمعة',
    ];

    return $lang == 'ar' && isset($dayArray[$day]) ? $dayArray[$day] : $day;
}

#convert from english month to arabic format
function month_to_arabic($month)
{
    $lang  = App::getLocale();
    $data = [
        "Jan" => "يناير",
        "Feb" => "فبراير",
        "Mar" => "مارس",
        "Apr" => "أبريل",
        "May" => "مايو",
        "Jun" => "يونيو",
        "Jul" => "يوليو",
        "Aug" => "أغسطس",
        "Sep" => "سبتمبر",
        "Oct" => "أكتوبر",
        "Nov" => "نوفمبر",
        "Dec" => "ديسمبر"
    ];
    return $lang == 'ar' && isset($data[$month]) ? $data[$month] : $month;
}

#convert from english time(a) to arabic format
function time_to_arabic($time)
{
    $lang  = App::getLocale();
    if ($lang == 'ar') $time = $time == 'pm' ? 'م' : 'ص';
    return $time;
}


/*
|----------------------------------------------------|
|----------------------------------------------------|
|                  other Helper Start                |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#remove html tags
function fix_text($text)
{
    $text = str_ireplace(array("\r", "\n", "\t"), '', $text);
    $text = str_ireplace(array("&nbsp;", "&hellip;", "&ndash;"), '', $text);
    $text = strip_tags($text);
    $text = stripslashes($text);
    return $text;
}

function generateTimeRange($startTime, $endTime, $intervalMinutes)
{
    $start = Carbon::parse($startTime);
    $end   = Carbon::parse($endTime);

    $range = [];

    if ($end->lt($start)) {
        $end   = Carbon::parse('24:00:00');
        while ($start->lt($end)) {
            $range[] = $start->toTimeString(); // You can customize the format as needed
            $start->addMinutes($intervalMinutes);
        }

        $start = Carbon::parse('00:00:00');
        $end   = Carbon::parse($endTime);
        while ($start->lt($end)) {
            $range[] = $start->toTimeString(); // You can customize the format as needed
            $start->addMinutes($intervalMinutes);
        }
    } else {
        while ($start->lt($end)) {
            $range[] = $start->toTimeString(); // You can customize the format as needed
            $start->addMinutes($intervalMinutes);
        }
    }

    return $range;
}

function generateTimeRangeWithDate($startTime, $endTime, $intervalMinutes, $date = '')
{
    $date  = is_null($date) ? Carbon::now()->format('Y-m-d') : Carbon::parse($date)->format('Y-m-d');
    $start = Carbon::parse($startTime);
    $end   = Carbon::parse($endTime);

    $range = [];

    if ($end->lt($start)) {
        $end   = Carbon::parse('24:00:00');
        while ($start->lt($end)) {
            $range[] = [
                'date' => $date,
                'time' => $start->toTimeString(),
            ]; // You can customize the format as needed
            $start->addMinutes($intervalMinutes);
        }

        $date  = Carbon::parse($date)->addDay()->format('Y-m-d');
        $start = Carbon::parse('00:00:00');
        $end   = Carbon::parse($endTime);
        while ($start->lt($end)) {
            $range[] = [
                'date' => $date,
                'time' => $start->toTimeString(),
            ]; // You can customize the format as needed
            $start->addMinutes($intervalMinutes);
        }
    } else {
        while ($start->lt($end)) {
            $range[] = [
                'date' => $date,
                'time' => $start->toTimeString(),
            ]; // You can customize the format as needed
            $start->addMinutes($intervalMinutes);
        }
    }

    return $range;
}

#get dates range from start_date to end_date
function get_date_range($startDate, $endDate)
{
    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($startDate, 5, 2),     substr($startDate, 8, 2), substr($startDate, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($endDate, 5, 2),     substr($endDate, 8, 2), substr($endDate, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

#check if value in key,value array
function is_in_array($array, $key, $key_value)
{
    $within_array = false;
    $result = [];
    foreach ($array as $k => $v) {

        if (is_array($v)) {
            $within_array = is_in_array($v, $key, $key_value);
            if ($within_array == true) {
                break;
            }
        } else {
            if ($v == $key_value && $k == $key) {
                $within_array = true;
                break;
            }
        }
    }
    return $within_array;
}

#randome active code
function active_code()
{
    //$code = '1234'; //for test work
    $code = rand(1111, 9999); //for real work
    return $code;
}

#user unseen notification count
function user_cart_count($user_id = null, $device_id = null)
{
    $count = 0;
    if (!is_null($device_id)) $count = Cart::where('device_id', $device_id)->count();
    if (!is_null($user_id))   $count = Cart::where('user_id', $user_id)->count();
    return $count;
}

#user favourite
function user_favourite($user_id, $to_id)
{
    $check = Favourite::where('user_id', $user_id)->where('to_id', $to_id)->first();
    return isset($check);
}

function user_block_list($user_id, $to_id)
{
    $check = User_block_list::where('user_id', $user_id)->where('to_id', $to_id)->first();
    return isset($check);
}

function check_user_block_list($user_id, $to_id)
{
    $check = User_block_list::where('user_id', $user_id)->where('to_id', $to_id)->first();
    if (!isset($check)) $check = User_block_list::where('user_id', $to_id)->where('to_id', $user_id)->first();
    return isset($check);
}

#genrate randome number
function generate_number($count)
{
    return str_random((int) $count);
}

#recursive function to convert the nested array into single array
function makeNonNestedRecursive(array &$outputArray, $key, array $inputArray)
{
    foreach ($inputArray as $inputKey => $value) {
        if (is_array($value)) {
            makeNonNestedRecursive($outputArray, $key . $inputKey . '_', $value);
        } else {
            $outputArray[$inputKey] = $value;
        }
    }
}
function makeNonNested(array $inputArray)
{
    $outputArray = [];
    makeNonNestedRecursive($outputArray, '', $inputArray);
    return $outputArray;
}
