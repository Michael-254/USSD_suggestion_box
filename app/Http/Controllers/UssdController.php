<?php

namespace App\Http\Controllers;

use App\Http\Ussd\States\NotStaff;
use App\Models\User;
use Illuminate\Http\Request;
use Sparors\Ussd\Machine;
use App\Http\Ussd\States\Welcome;
use Illuminate\Support\Facades\Session;

class UssdController extends Controller
{
    public function index(Request $request)
    {
        $text = $request->input('text');
        $session_id = $request->input('sessionId');
        $phone_number = $request->input('phoneNumber');
        $service_code = $request->input('serviceCode');
        $network_code = $request->input('networkCode');
        Session::put('phone_number', $phone_number);

        $user = User::wherePhoneNumber($phone_number)->first();

        if($user){
        $level = explode("*", $text);
        $ussd = (new Machine())->setSessionId($session_id)
            ->setInput(end($level))
            ->setInitialState(Welcome::class);
        }else{
            $level = explode("*", $text);
            $ussd = (new Machine())->setSessionId($session_id)
                ->setInput(end($level))
                ->setInitialState(NotStaff::class);
        }

        return response($ussd->run()['message'])->header('Content-Type', 'text/plain');
    }
}
