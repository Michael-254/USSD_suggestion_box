<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class Error extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('CON Error menu')
                   ->lineBreak(1)
                   ->line('0:Back');
    }

    protected function afterRendering(string $argument): void
    {
        $this->decision->equal('0',Welcome::class)
                       ->any(Error::class);
    }
}
