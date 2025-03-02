<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class paymentController extends Controller
{

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
            'amount'      => 'required',
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
            "&merchantTransactionId=" . generate_number(10) .
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

        if (is_success($code)) {

            // Payment_report::create([
            //     'checkout_id'   => $responseData['id'],
            //     'order_id'      => $request->order_id
            // ]);
            return view('payment.hyperpay', compact('responseData'));
        } else
            return back()->withErrors('فشل عمليه الدفع . يرجى المحاوله فى وقت لاحق');
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

        if (is_success($code)) {

            // $payment_report  = Payment_report::where('checkout_id', $request['id'])->first();

            // //store payment
            // $payment = Payment::create([
            //     'name'       => Auth::user()->name,
            //     'amount'     => $responseData['amount'],
            //     'status'     => 'success',
            //     'user_id'    => Auth::id(),
            //     'order_id'   => $payment_report->order_id,
            // ]);

            // $payment_report->delete();
            return redirect(route('admin_home'));
        } else
            return redirect(route('admin_home'))->withErrors('فشل عمليه الدفع . يرجى المحاوله فى وقت لاحق');
    }
}
