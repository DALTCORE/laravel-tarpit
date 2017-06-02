<?php

return [

    /**
     * Enable the HTTP-Tarpit
     */
    'enabled' => env('TARPIT_ENABLE', true),

    /**
     * HTTP-Tarpit API Key
     */
    'type'    => env('TARPIT_API_KEY', null),

    /**
     * API URL
     */
    'url'     => env('TARPIT_ENDPOINT', 'api.http-tarpit.org'),

    /**
     * API Version
     */
    'version' => env('TARPIT_VERSION', 'v1'),

    /**
     * Handle requests in realtime or via cache
     */
    'type'    => env('TARPIT_HANDLER', 'realtime'),

    /**
     * Current website domain
     */
    'domain'  => env('TARPIT_DOMAIN', 'basis-cms.vm')
];
