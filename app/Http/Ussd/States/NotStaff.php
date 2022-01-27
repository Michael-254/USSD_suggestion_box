<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class NotStaff extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('CON This number is not registered to any of our staff.Request assistance from HR');
    }

    protected function afterRendering(string $argument): void
    {
        //
    }
}
