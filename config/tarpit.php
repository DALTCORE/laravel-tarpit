<?php

return [

    /*
     * Enable the HTTP-Tarpit
     */
    'enabled' => env('TARPIT_ENABLE', true),

    /*
     * HTTP-Tarpit API Key
     */
    'key'     => env('TARPIT_API_KEY', false),

    /*
     * API URL
     */
    'url'     => env('TARPIT_ENDPOINT', 'api.http-tarpit.org'),

    /*
     * API Version
     */
    'version' => env('TARPIT_VERSION', 'v2'),

    /*
     * Handle requests in realtime or via cache
     */
    'type'    => env('TARPIT_HANDLER', 'realtime'),

    /*
     * Current website domain
     */
    'domain'  => env('TARPIT_DOMAIN', env('APP_URL', 'unknown.com')),
];
