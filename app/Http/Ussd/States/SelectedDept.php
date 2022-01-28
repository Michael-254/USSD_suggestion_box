<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class SelectedDept extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('CON Message respondents.')
                   ->lineBreak(2)
                   ->line('1:HOD/Supervisor in Copy of message')
                   ->line('2:Confidential message')
                   ->line('99:Back');
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->messageType = $argument;
        $this->decision->between(1, 2, Query::class)
                       ->equal('99', Welcome::class)
                       ->any(Error::class);
    }
}
