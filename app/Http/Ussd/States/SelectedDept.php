<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class SelectedDept extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->line('1:HOD/Supervisor in Copy of message')
                   ->line('2:Confidential message')
                   ->line('99:Back')
                   ->line('0:Exit');
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->messageType = $argument;
        $this->decision->between(1, 2, Query::class)
                       ->equal('99', Welcome::class)
                       ->any(Error::class);
    }
}
