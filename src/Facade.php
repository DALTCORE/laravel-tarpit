<?php

namespace DALTCORE\Tarpit;

/**
 * Class Facade.
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tarpit';
    }
}
