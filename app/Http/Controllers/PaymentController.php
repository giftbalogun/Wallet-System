<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function store(Request $request)
    {
        $data = [
            'tx_ref' => rand(),
            'amount' => $request->amount,
            'currency' => $request->currency,
            'redirect_url' => route('flutterwave-callback'),
            'customer' => [
                'email' => $request->email,
                'phonenumber' => $request->phone_no,
                'name' => $request->first_name . $request->last_name,
            ],
        ];
        $url = 'https://api.flutterwave.com/v3/payments';
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer FLWSECK-7bf613bcc34fa94b839fae106b852084-X', //Secret key of your account
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($curl, CURLOPT_TIMEOUT, 200);
        $response_body = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $result = json_decode($response_body, true);
        if ($err) {
            throw new \Exception($err);
        }

        if (isset($result['status']) && $result['status'] == 'success') {
            if (
                isset($result['data']['link']) &&
                $result['data']['link'] != ' '
            ) {
                return Redirect::to($result['data']['link']);
            }
        }

        throw new \Exception('Your transaction could not processed.');
    }

    public function callback(Request $request)
    {
        $response = $request->all();
        if ($response['status'] == 'completed') {
            $status = 'SUCCESS';
            echo 'Call back da work small';
        } else {
            $status = 'FAIL';
            echo 'noCall back da work small';
        }
        //Store the transaction as per your requirement
    }
}
