<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAPxXzVME:APA91bGnKU_IxxGB8rGCWLSgKX0yJtzlwQV68P_svr4y43ERwA1v-mDhC3cwjWII-p-gLVvEVsJkqWjuEWG8fJgpxKW6LJu-G976tu8FU1V4jA4UcAXRnO--gYiLkc8O-5WDZRfkK3e0'),
        'sender_id' => env('FCM_SENDER_ID', '270951208129'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
