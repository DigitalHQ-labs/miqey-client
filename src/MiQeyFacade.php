<?php

namespace Libaro\MiQey;

use Illuminate\Support\Facades\Facade;

class MiQeyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'miqey';
    }
}
