<?php

namespace App\Http\Ussd\States;

use App\Mail\CommsMail;
use App\Models\Department;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use AfricasTalking\SDK\AfricasTalking;
use Sparors\Ussd\State;

class Query extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('CON Type your Query');
    }

    protected function afterRendering(string $argument): void
    {
        $phone = Session::get('phone_number');
        $dept = $this->record->get('dept');
        $message_type = $this->record->get('messageType');
        $department = Department::skip($dept - 1)->first();
        $user = User::wherePhoneNumber($phone)->first();
        $suggestion = Suggestion::create(['user_id' => $user->id, 'department_id' => $department->id, 'query' => $argument]);

        if ((int)$message_type == 1) {
            $suggestion->update(['type' => 'notify']);
        }
        if($user->country == 'Kenya'){
            $this->sendSMSKenya($user->phone_number);
        }else{
            $this->sendSMSUganda($user->phone_number);
        }
        $this->decision->any(SavedQuery::class);
    }

    protected function sendSMSKenya($phone_number)
    {
        $username = 'Better_Globe_Kenya';
        $apiKey   = 'mikedee';
        $AT       = new AfricasTalking($username, $apiKey);
        $sms      = $AT->sms();
        $result   = $sms->send([
            'from' => 'BGF',
            'to'      => $phone_number,
            'message' => 'Your message has been well received. We shall revert back'
        ]);
        Log::info($result);
    }

    protected function sendSMSUganda($phone_number)
    {
        $username = 'Better_Globe_Uganda';
        $apiKey   = 'mikedee';
        $AT       = new AfricasTalking($username, $apiKey);
        $sms      = $AT->sms();
        $result   = $sms->send([
            'from' => 'BGF',
            'to'      => $phone_number,
            'message' => 'Your message has been well received. We shall revert back'
        ]);
        Log::info($result);
    }
}
