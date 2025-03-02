<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_provider;
use App\Models\Subscription;
use App\Models\Package;
use App\Models\Package_subscripe;
use Auth;
use Session;
use App\Models\User;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    /*
    |----------------------------------------------------|
    |               surepay Payment Start                |
    |----------------------------------------------------|
    */

    #send_to_whatsapp
    public function send_to_whatsapp()
    {
        return view('send_to_whatsapp');
    }

    #post_send_to_whatsapp
    public function post_send_to_whatsapp(Request $request)
    {
        #send_to_whatsapp
        $response = send_to_whatsapp(convert_phone_to_international_format($request->phone, $request->phone_code), $request->message);

        return $response;
    }


    /*
    |----------------------------------------------------|
    |               surepay Payment Start                |
    |----------------------------------------------------|
    */

    #surepay
    public function surepay(Request $request)
    {
        $order      = Order::whereId($request->order_id)->first();
        if(!isset($order)) return 'order id is required';
        //$user       = $order->user;
        $amount     = $order->total_after_promo;
        $url        = 'https://bills.surepay.sa/api/v1/bills/create';
        #Body
        $fields   = array(
            "application_id"     => "1677",
            "application_secret" => "6A87J1sl9iJbOm5HKNw8",
            "expiry_minutes"     => 0,
            "expiry_hours"       => 0,
            "customer_name"      => "Quicknow App",
            "customer_email"     => "salers@quicknow.com",
            "customer_mobile"    => "0544222879",
            "due_date"           => date('d-m-Y'),
            "expiry_date"        => 1,
            //"add_tax"            => "on",
            //"tax_value"          => 0,
            //"add_discount"       => "on",
            //"discount_type"      => "fixed",
            //"discount_value"     => 0,
            "reference_id"       => isset($order) ? (string) $order->id : (string) rand(11, 99),
            "lang"               => "ar",
            "redirect_url"       => "https://quicknow.com.sa/surepay_success",
            "webhook_url"        => "https://quicknow.com.sa",
            "tags"               => "quicknow",
            "items"              => array(array(
                "name"     => "quicknow service",
                "price"    => (float) $amount,
                "quantity" => 1
            ))
        );

        $fields_string = json_encode($fields);
        //dd($fields_string);
        //open connection
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
            ),
            CURLOPT_POSTFIELDS => $fields_string
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        if ($result) {
            $urldecode  = (json_decode($result, true));
            //dd($urldecode['data']['pay_url']);
            if(isset($urldecode['data']['pay_url'])) return redirect($urldecode['data']['pay_url']);
        }

        return 'err';


        //return view('payment.surepay', compact('amount'));
    }

    #surepay_success
    public function surepay_success(Request $request)
    {
        return 'success';
    }

    /*
    |----------------------------------------------------|
    |                urway Payment Start                 |
    |----------------------------------------------------|
    */

    public function urway_payment(Request $request)
    {
        Session::forget('urway_request');
        Session::put('urway_request', ['id' => $request->id]);

        $user               = Auth::user();
        $trackid            = rand(1111, 9999);
        $terminalId         = 'plusfitnes';
        $password           = 'plus@123';
        $merchantKey        = 'fe87eca4de559ac64b8079c5e8d041245944e6fe7c91da58d9204bef10114405';
        $amount             = $request->has('amount') ? floatval($request->amount) : 0.00; #floatval
        $currency_code      = 'SAR';

        $txn_details        = "$trackid|$terminalId|$password|$merchantKey|$amount|$currency_code";
        $hash               = hash('sha256', $txn_details);

        $fields             = array(
            'trackid'       => $trackid,
            'terminalId'    => $terminalId,
            'customerEmail' => empty($user) && empty($user->email) ? "test@gmail.com" : $user->email,
            'action'        => "1",
            'merchantIp'    => $_SERVER['SERVER_ADDR'],
            'password'      => $password,
            'currency'      => $currency_code,
            'country'       => "SA",
            'amount'        => $amount,
            'requestHash'   => $hash
        );
        $data               = json_encode($fields);

        $ch                 = curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result              = curl_exec($ch);
        curl_close($ch);
        $urldecode           = (json_decode($result, true));

        if (isset($urldecode['payid']) && $urldecode['payid'] != NULL) {
            #store your payid in the transactions table with user id and order id
            $url = $urldecode['targetUrl'] . "?paymentid=" . $urldecode['payid'];
            echo '<html><form name="myform" method="POST" action="' . $url . '"><h1 style="color: black"> عملية الدفع قيد التحميل</h1><h1 style="color: black"> Transaction is processing.......</h1></form><script type="text/javascript">document.myform.submit();</script></html>';
        }

        echo "<b>فشلت عملية الدفع</b><b>Something went wrong!!!!</b>";
    }

    public function urway_payment_status(Request $request)
    {
        #parameters from payment getaway
        $amount                     =  $_GET['amount'];
        $status                     =  $_GET['ResponseCode'];
        $result                     =  $_GET['Result'];
        $id                         =  $_GET['TranId'];

        $responseHash               =  $_GET['responseHash'];

        $merchantKey                =  'fe87eca4de559ac64b8079c5e8d041245944e6fe7c91da58d9204bef10114405';

        $requestHash                =  "$id|$merchantKey|$status|$amount";
        $hash                       =  hash('sha256', $requestHash);


        if ($hash == $responseHash  && $result == 'Successful') {
            #here compare the  $_GET['TranId'] with the previous saved one
            return false;
        } else {
            return false;
        }
    }

    public function urway_success(Request $request)
    {
        if (isset($request->Result) && $request->Result == "Successful") {
            $urway_request  = Session::get('urway_request');
            $id             = $urway_request['id'];

            Session::forget('urway_request');
            Session::forget('id');
            Session::put('id', $id);

            return redirect()->route('my_fatoorah_success');
        } else {
            session()->flash('success', Translate('حدث خطأ اثناء عملية الدفع'));
            return redirect()->route('site_home');
        }
    }

    /*
    |----------------------------------------------------|
    |             my_fatoorah Payment Start              |
    |----------------------------------------------------|
    */

    #my_fatoorah
    public function my_fatoorah($type, $id, $amount)
    {
        $token  = "cxu2LdP0p0j5BGna0velN9DmzKJTrx3Ftc0ptV8FmvOgoDqvXivkxZ_oqbi_XM9k7jgl3SUriQyRE2uaLWdRumxDLKTn1iNglbQLrZyOkmkD6cjtpAsk1_ctrea_MeOQCMavsQEJ4EZHnP4HoRDOTVRGvYQueYZZvVjsaOLOubLkdovx6STu9imI1zf5OvuC9rB8p0PNIR90rQ0-ILLYbaDZBoQANGND10HdF7zM4qnYFF1wfZ_HgQipC5A7jdrzOoIoFBTCyMz4ZuPPPyXtb30IfNp47LucQKUfF1ySU7Wy_df0O73LVnyV8mpkzzonCJHSYPaum9HzbvY5pvCZxPYw39WGo8pOMPUgEugtaqepILwtGKbIJR3_T5Iimm_oyOoOJFOtTukb_-jGMTLMZWB3vpRI3C08itm7ealISVZb7M3OMPPXgcss9_gFvwYND0Q3zJRPmDASg5NxRlEDHWRnlwNKqcd6nW4JJddffaX8p-ezWB8qAlimoKTTBJCe5CnjT4vNjnWlJWscvk38VNIIslv4gYpC09OLWn4rDNeoUaGXi5kONdEQ0vQcRjENOPAavP7HXtW1-Vz83jMlU3lDOoZsdEKZReNYpvdFrGJ5c3aJB18eLiPX6mI4zxjHCZH25ixDCHzo-nmgs_VTrOL7Zz6K7w6fuu_eBK9P0BDr2fpS";
        //$basURL = "https://api.myfatoorah.com"; //Live
        $basURL = "https://apitest.myfatoorah.com"; // Test
        $user   = Auth::user();
        $rand   = rand(11111111, 99999999);


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$basURL/v2/SendPayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"NotificationOption\":\"LNK\",\"CustomerName\": \"$user->name\",\"DisplayCurrencyIso\": \"SAR\", \"MobileCountryCode\":\"+966\",\"CustomerMobile\": \"$user->phone\",\"CustomerEmail\": \"$user->email\",\"InvoiceValue\": $amount,\"CallBackUrl\": \"https://plusfitnes.com/my_fatoorah_success\",\"ErrorUrl\": \"https://plusfitnes.com/my_fatoorah_faild\",\"Language\": \"en\",\"CustomerReference\" :\"ref 1\",\"CustomerCivilId\":$rand,\"UserDefinedField\": \"Custom field\",\"ExpireDate\": \"\",\"CustomerAddress\" :{\"Block\":\"\",\"Street\":\"\",\"HouseBuildingNo\":\"\",\"Address\":\"\",\"AddressInstructions\":\"\"},\"InvoiceItems\": [{\"ItemName\": \"Coach Subscripe\",\"Quantity\": 1,\"UnitPrice\": $amount}]}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),

        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            session()->flash('success', Translate('حدث خطأ اثناء عملية الدفع'));
            return redirect()->route('site_home');
        } else {
            $json        = json_decode((string) $response, true);
            if (!isset($json["IsSuccess"]) || !$json["IsSuccess"]) {
                session()->flash('success', Translate('حدث خطأ اثناء عملية الدفع'));
                return redirect()->route('site_home');
            }
            $payment_url = $json["Data"]["InvoiceURL"];
            Session::put('id', $id);
            return redirect($payment_url);
        }
    }

    #my_fatoorah_success
    public function my_fatoorah_success(Request $request)
    {
        #get id
        $id = Session::get('id');
        Session::forget('id');
        #redirect with msg
        session()->flash('success', Translate('تم الدفع بنجاح'));
        return redirect()->route('site_home');
    }

    #my_fatoorah_faild
    public function my_fatoorah_faild(Request $request)
    {
        Session::forget('id');
        #redirect with msg
        session()->flash('success', Translate('حدث خطأ اثناء عملية الدفع'));
        return redirect()->route('site_home');
    }

    /*
    |----------------------------------------------------|
    |----------------------------------------------------|
    |             HyperPay Payment Start                 |
    |----------------------------------------------------|
    |----------------------------------------------------|
    */

    /********* For Test  ***********/
    // Testing Cards for credit Card :
    // 4111111111111111 05/21 cvv2 123  (Success)
    // 5204730000002514 05/22 cvv2 251  (Fail)

    /********* create form  ***********/
    public function createForm(Request $request)
    {

        $this->validate($request, [
            'user_id'    => 'required|exists:users,id',
            'amount'     => 'required',
            // 'order_id'   => 'required',
        ]);

        //data
        $user   = User::whereId($request->user_id)->firstOrFail();
        $amount = $request->amount;

        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8ac7a4c86fd10a7a016fd10ff55e0014" .
            "&amount=" . $amount . // Amount
            "&currency=SAR" . //SAR
            "&testMode=EXTERNAL" .
            "&merchantTransactionId=" . rand(1111111111, 9999999999) .
            "&customer.email=" . $user->email .
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzg2ZmQxMGE3YTAxNmZkMTBmN2ExYzAwMGZ8TU1BU1g5N0RjYQ=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $responseData = json_decode($responseData, true);
        $code = isset($responseData['result']['code']) ? $responseData['result']['code']  : '-1';

        #Success
        if (is_success($code)) return view('payment.hyperpay', compact('responseData'));
        #Faild
        return api_response(0, 'faild');
    }

    /********* payment Result  ***********/
    public function paymentResult(Request $request)
    {
        $url  = "https://test.oppwa.com" . $request['resourcePath'];
        $url .= "?entityId=8ac7a4c86fd10a7a016fd10ff55e0014";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzg2ZmQxMGE3YTAxNmZkMTBmN2ExYzAwMGZ8TU1BU1g5N0RjYQ=='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $responseData = json_decode($responseData, true);
        $code = isset($responseData['result']['code']) ? $responseData['result']['code']  : '-1';

        #Success
        if (is_success($code)) return api_response(1, 'success');
        #Faild
        return api_response(0, 'faild');
    }
}
