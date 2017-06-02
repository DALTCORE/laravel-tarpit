<?php

namespace DALTCORE\Tarpit;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tarpit';
    }
}
