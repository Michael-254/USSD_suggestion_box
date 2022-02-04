<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ResponseController extends Controller
{

    public function messages()
    {
        $messages = Suggestion::paginate(10)
            ->withQueryString()
            ->through(fn ($sugg) => [
                'id' => $sugg->id,
                'user' => $sugg->initiator,
                'department' => $sugg->dept,
                'query' => Str::limit($sugg->query,20),
                'type' => $sugg->type,
                'response' => Str::limit($sugg->response,20),
            ]);

      return Inertia::render('Admin/Message', [
            'Messages' => $messages
        ]);
    }

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
