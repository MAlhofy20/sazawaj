<?php

namespace App\Http\Controllers\api;

use App\Models\Order;
use App\Models\Order_provider;
use App\Models\Subscription;
use App\Models\Package;
use App\Models\Package_subscripe;
use Auth;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class paymentController extends Controller
{
    /*
    |----------------------------------------------------|
    |                urway Payment Start                 |
    |----------------------------------------------------|
    */

    public function urway_payment(Request $request){
        Session::forget('urway_request');
        Session::put('urway_request' , ['id' => $request->id]);

        $user               = Auth::user();
        $trackid            = rand(1111,9999);
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
        curl_setopt($ch     , CURLOPT_CUSTOMREQUEST     , "POST");
        curl_setopt($ch     , CURLOPT_POSTFIELDS        , $data);
        curl_setopt($ch     , CURLOPT_RETURNTRANSFER    , true);
        curl_setopt($ch     , CURLOPT_HTTPHEADER        , array(
                'Content-Type: application/json'        ,
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch     , CURLOPT_TIMEOUT, 5);
        curl_setopt($ch     , CURLOPT_CONNECTTIMEOUT, 5);
        $result              = curl_exec($ch);
        curl_close($ch);
        $urldecode           = (json_decode($result,true));

        if(isset($urldecode['payid']) && $urldecode['payid'] != NULL){
            #store your payid in the transactions table with user id and order id
            $url=$urldecode['targetUrl']."?paymentid=".$urldecode['payid'];
            echo '<html><form name="myform" method="POST" action="'.$url.'"><h1 style="color: black"> عملية الدفع قيد التحميل</h1><h1 style="color: black"> Transaction is processing.......</h1></form><script type="text/javascript">document.myform.submit();</script></html>';
        }

        echo "<b>فشلت عملية الدفع</b><b>Something went wrong!!!!</b>";
    }

    public function urway_payment_status(Request $request){
        #parameters from payment getaway
        $amount                     =  $_GET['amount'];
        $status                     =  $_GET['ResponseCode'];
        $result                     =  $_GET['Result'];
        $id                         =  $_GET['TranId'];

        $responseHash               =  $_GET['responseHash'];

        $merchantKey                =  'fe87eca4de559ac64b8079c5e8d041245944e6fe7c91da58d9204bef10114405';

        $requestHash                =  "$id|$merchantKey|$status|$amount";
        $hash                       =  hash('sha256', $requestHash);


        if($hash == $responseHash  && $result == 'Successful') {
            #here compare the  $_GET['TranId'] with the previous saved one
            return false;
        }
        else
        {
            return false;
        }
    }

    public function urway_success(Request $request)
    {
        if(isset($request->Result) && $request->Result == "Successful"){
            $urway_request  = Session::get('urway_request');
            $id             = $urway_request['id'];

            Session::forget('urway_request');
            Session::forget('id');
            Session::put('id', $id);

            return redirect()->route('my_fatoorah_success');
        }else{
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
    public function my_fatoorah(Request $request)
    {
        //return '';//stop
        //$token  = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";
        $token  = "IBLu6BP04nVz6pC8XsjZDSruq0OzA3dKf3MMAkF3cCd38i73dfeJ77L48aCZ3W5AXCN9xCI7qbWdXPmDay-K_Jg4YxZOG_PW4Ovg2SY-2Vy-RUsh33vUQqVH7L5YlSq1B6nxj85o-ER1EeQXHolzPLFb3KU66-dRq8mibJCWWujbuSrt7Shu9GDiouL2KM52Sw4t5vd7C9KhDAuPEqfFOMIf3eGls_2FqscMRPjva9EwRjVeBnZg0TrcH5rEuc0Iq6EoPsXL5lvN32bQ0WtFisrhd7nx2F9jCf_efwpu_pPsv_gweVmt8ly5AsiX1lSPTbeY5ViuZT691oBXxC6zoerSYhqNg_hXr3lKEHhNIySYIbzQlW8R5B7s1bAuKNGORo14hI-H03fbeLHhbQ4CtwfBDls-AcyqiZoY5PO-Sx-ZYSaE8pNYMM41c2JvqO-TXahATmdegzLoBruyY4Q0MXb_Psr2QfS-V47Jgk5scls_TL2gBdgoReBtnWfNexJvMWtE2dFWoQFZDlFZZxBSKnPgGt5gCBN0sNbhctBL2zYw8kO4OHCIe-QIqwJv2EDhT2DWwd2yPrSaDA24MF-7mzFVNtYCwkNXcrMNuBHtJk_pt0fx5DP-wHWrdiSGIF1C-m9ppQ0jtkzOJiUhblyu6hvV8etnB4diomefWa_oAId_aRJ24_PTD4jOxdqQRJ7C_4PTdQqmN4-H2-3i9mV0LK_MDkQ5DWPaSrsRONR05GIl81Tw";
        $basURL = "https://api-sa.myfatoorah.com"; //Live
        //$basURL = "https://apitest.myfatoorah.com"; // Test
        $user   = User::whereId($request->user_id)->first();
        $rand   = rand(11111111 , 99999999);

        //dd($user);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$basURL/v2/ExecutePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"PaymentMethodId\":\"$request->payment_id\",\"CustomerName\": \"$user->name\",\"DisplayCurrencyIso\": \"SAR\", \"MobileCountryCode\":\"+966\",\"CustomerMobile\": \"$user->phone\",\"CustomerEmail\": \"jadwaah@info.sa\",\"InvoiceValue\": $request->amount,\"CallBackUrl\": \"https://malaebpadel.com/api/my_fatoorah_success\",\"ErrorUrl\": \"https://malaebpadel.com/api/my_fatoorah_faild\",\"Language\": \"en\",\"CustomerReference\" :\"ref 1\",\"CustomerCivilId\":$rand,\"UserDefinedField\": \"Custom field\",\"ExpireDate\": \"\",\"CustomerAddress\" :{\"Block\":\"\",\"Street\":\"\",\"HouseBuildingNo\":\"\",\"Address\":\"\",\"AddressInstructions\":\"\"},\"InvoiceItems\": [{\"ItemName\": \"Items\",\"Quantity\": 1,\"UnitPrice\": $request->amount}]}",
            //CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $token",
                "Content-Type: application/json",
                "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
                "Accept: application/json, text/javascript, */*; q=0.01",
                "Accept-Language: en-us,en;q=0.5",
                "Accept-Encoding: gzip, deflate",
                "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
                "Keep-Alive: 115",
                "Connection: keep-alive",
                "X-Requested-With: XMLHttpRequest",
            ),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $json        = json_decode((string) $response, true);
            if (!isset($json["IsSuccess"]) || !$json["IsSuccess"]) return 'err';
            $payment_url = $json["Data"]["PaymentURL"];
            return redirect($payment_url);
        }
    }

    #my_fatoorah
    public function my_fatoorah_methods(Request $request)
    {
        //return [];//stop
        //$token  = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";
        $token  = "IBLu6BP04nVz6pC8XsjZDSruq0OzA3dKf3MMAkF3cCd38i73dfeJ77L48aCZ3W5AXCN9xCI7qbWdXPmDay-K_Jg4YxZOG_PW4Ovg2SY-2Vy-RUsh33vUQqVH7L5YlSq1B6nxj85o-ER1EeQXHolzPLFb3KU66-dRq8mibJCWWujbuSrt7Shu9GDiouL2KM52Sw4t5vd7C9KhDAuPEqfFOMIf3eGls_2FqscMRPjva9EwRjVeBnZg0TrcH5rEuc0Iq6EoPsXL5lvN32bQ0WtFisrhd7nx2F9jCf_efwpu_pPsv_gweVmt8ly5AsiX1lSPTbeY5ViuZT691oBXxC6zoerSYhqNg_hXr3lKEHhNIySYIbzQlW8R5B7s1bAuKNGORo14hI-H03fbeLHhbQ4CtwfBDls-AcyqiZoY5PO-Sx-ZYSaE8pNYMM41c2JvqO-TXahATmdegzLoBruyY4Q0MXb_Psr2QfS-V47Jgk5scls_TL2gBdgoReBtnWfNexJvMWtE2dFWoQFZDlFZZxBSKnPgGt5gCBN0sNbhctBL2zYw8kO4OHCIe-QIqwJv2EDhT2DWwd2yPrSaDA24MF-7mzFVNtYCwkNXcrMNuBHtJk_pt0fx5DP-wHWrdiSGIF1C-m9ppQ0jtkzOJiUhblyu6hvV8etnB4diomefWa_oAId_aRJ24_PTD4jOxdqQRJ7C_4PTdQqmN4-H2-3i9mV0LK_MDkQ5DWPaSrsRONR05GIl81Tw";
        $basURL = "https://api-sa.myfatoorah.com"; //Live
        //$basURL = "https://apitest.myfatoorah.com"; // Test

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$basURL/v2/InitiatePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"InvoiceAmount\": $request->amount,\"CurrencyIso\": \"SAR\"}",
            //CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $token",
                "Content-Type: application/json",
                "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
                "Accept: application/json, text/javascript, */*; q=0.01",
                "Accept-Language: en-us,en;q=0.5",
                "Accept-Encoding: gzip, deflate",
                "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
                "Keep-Alive: 115",
                "Connection: keep-alive",
                "X-Requested-With: XMLHttpRequest",
            ),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $json   = json_decode((string) $response, true);
            if (!isset($json["IsSuccess"]) || !$json["IsSuccess"]) return 'err';
            return $json["Data"]["PaymentMethods"];
        }
    }

    #my_fatoorah_success
    public function my_fatoorah_success(Request $request)
    {
        return 'success';
    }

    #my_fatoorah_faild
    public function my_fatoorah_faild(Request $request)
    {
        return 'faild';
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
