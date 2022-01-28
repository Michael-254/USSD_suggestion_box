<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class SavedQuery extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text('END Your text has been received. We shall revert');
    }

    protected function afterRendering(string $argument): void
    {
        //
    }
}
