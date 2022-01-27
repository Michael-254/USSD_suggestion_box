<?php

namespace App\Http\Ussd\States;

use App\Models\Department;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Support\Facades\Session;
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
        $department_id= Department::skip($dept - 1)->first()->id;
        $user_id = User::wherePhoneNumber($phone)->first()->id;
        Suggestion::create(['user_id' => $user_id,'department_id' => $department_id, 'query' => $argument]);

        $this->decision->any(SavedQuery::class);
    }
}
