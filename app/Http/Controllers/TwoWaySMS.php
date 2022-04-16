<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Department;
use App\Models\SMSProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TwoWaySMS extends Controller
{
    public function SendSMS($message, $phone_number)
    {
        $username = 'sandbox';
        $apiKey   = '2043ed93bab94f0d7efb07b3895a1d1e1a697198806310a61b1caf05b35dfe02';
        $AT       = new AfricasTalking($username, $apiKey);
        $sms      = $AT->sms();
        $result   = $sms->send([
            'from' => '39980',
            'to'      => $phone_number,
            'message' => $message,
        ]);
    }

    public function index(Request $request)
    {
        $incoming_text = $request['text'];
        $phone_number = $request['from'];

        $find_user = User::where('phone_number', $phone_number)->first();
        if (!$find_user) {
            $message = 'Sorry We are unable find this number on our database.Kindly contact HR for assistance';
            $this->SendSMS($message, $phone_number);
        } else {
            $progress = SMSProgress::where('user_id', $find_user->id)->first();
            if ($progress) {
                if ($progress->progress == 1) {
                    $depts = \Arr::flatten(Department::select('id')->get()->toArray());
                    if (in_array((int)$incoming_text, $depts)) {
                        $this->sendType($find_user, $incoming_text);
                    } else {
                        $this->WrongSelection($find_user);
                    };
                } elseif ($progress->progress == 2) {
                    $array = [1, 2];
                    if (in_array((int)$incoming_text, $array)) {
                        $this->TypeQuery($find_user, $incoming_text);
                    } else {
                        $this->WrongSelection($find_user);
                    };
                } elseif ($progress->progress == 3) {
                    SMSProgress::where('user_id', $find_user->id)->first()->update(['progress' => '4', 'query' => $incoming_text]);
                    $this->EndIt($find_user);
                }
            } else {
                $this->SelectDept($find_user);
            }
        }
    }

    public function SelectDept($user)
    {
        $array = [];
        $depts = Department::select('id', 'department')->get();
        foreach ($depts as $dept) {
            $array[$dept->id] = $dept->department;
        }
        $flattened = $array;
        array_walk($flattened, function (&$value, $key) {
            $value = "{$key}:{$value}";
        });
        $message = "Welcome to BGF suggestion box. Please select department in query\n" .
            implode("\n ", $flattened);
        $this->SendSMS($message, $user->phone_number);
        SMSProgress::create(['user_id' => $user->id, 'progress' => '1']);
    }

    public function sendType($user, $incoming_text)
    {
        $message = "1: Do you want HOD in Copy\n 2: Confidential Message";
        $this->SendSMS($message, $user->phone_number);
        SMSProgress::where('user_id', $user->id)->first()->update(['progress' => '2', 'department_id' => $incoming_text]);
    }

    public function TypeQuery($user, $incoming_text)
    {
        $message = 'Type your Message';
        $this->SendSMS($message, $user->phone_number);
        SMSProgress::where('user_id', $user->id)->first()->update(['progress' => '3', 'type' => $incoming_text]);
    }

    public function EndIt($user)
    {
        $message = 'Your message has been well received. We shall revert back';
        $this->SendSMS($message, $user->phone_number);
    }

    public function WrongSelection($user)
    {
        $message = 'Wrong selection please try again';
        $this->SendSMS($message, $user->phone_number);
    }
}
