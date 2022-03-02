<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    public function index()
    {
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilio_sid = getenv('TWILIO_SID');
        $twilio_verify_sid = getenv('TWILIO_VERIFY_SID');
        $twilio = new Client($twilio_sid, $token);

        $twilio->verify->v2
            ->services($twilio_verify_sid)
            ->verifications->create('+2348122787177', 'sms');

        echo $twilio->twilio;
    }
}
