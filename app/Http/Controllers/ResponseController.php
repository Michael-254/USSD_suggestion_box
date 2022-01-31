<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
{

    public function sendSMS()
    {
        $username = 'sandbox';
        $apiKey   = '0b1d14f33ed4b882b2b3d307e16af000d6ac61967bdd3debc61197629892809f';
        $AT       = new AfricasTalking($username, $apiKey);

        $sms      = $AT->sms();

        $result   = $sms->send([
            'to'      => '+254717606015',
            'message' => 'Hello World!'
        ]);

        Log::info($result);
        print_r($result);
    }
}
