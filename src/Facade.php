<?php

namespace DALTCORE\Tarpit;

/**
 * Class Facade
 *
 * @package DALTCORE\Tarpit
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
