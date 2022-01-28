<?php

namespace App\Http\Ussd\States;

use App\Models\Department;
use Sparors\Ussd\State;

class Welcome extends State
{
    protected function beforeRendering(): void
    {
        $department = Department::pluck('department')->toArray();
        //$this->record->pageNo = 1;

        $this->menu->text('CON Welcome To BGF Suggestion Box.')
                   ->lineBreak(2)
                   ->line('Select Department in Query')
                   ->paginateListing(
                        $department
                        , 1, 10, ':');
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->dept = $argument;
        $this->decision->between(1, 9, SelectedDept::class)
                       ->any(Error::class);
    }
}
