<?php

namespace DALTCORE\Tarpit\Services;

use Carbon\Carbon;
use File;
use GuzzleHttp\Client;

/**
 * Class tarpit
 *
 * @package App\Helpers
 */
class Tarpit
{
    /**
     * @param $request
     * @param $fields
     *
     * @return null|string
     */
    public static function handler($request, $fields)
    {
        if (config('tarpit.enabled') == true) {
            $params = [
                'form_params' => [
                    'type'   => config('tarpit.type'),
                    'ip'     => $request->ip(),
                    'from'   => str_replace(['http://', 'https://', '/'], '', config('tarpit.domain')),
                    'uri'    => $request->server('REQUEST_URI'),
                    'fields' => $fields,
                    'log'    => 0
                ]
            ];
            $path = public_path('tarpit.cache');

            // Hit and run, sync the clients!
            try {
                $client = Tarpit::client();
                $res = $client->request(
                    'POST',
                    'https://' . config('tarpit.url') . '/api/' .
                    config('tarpit.version') . '/ip/sync',
                    $params
                );
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }

            /**
             * Tarpit Block code
             */
            if ($params['form_params']['type'] === 'realtime') {
                try {
                    $client = Tarpit::client();
                    $res = $client->request(
                        'POST',
                        'https://' . config('tarpit.url') . '/api/' .
                        config('tarpit.version') . '/ip/sync',
                        $params
                    );
                    $json = $res->getBody()->getContents();
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                }
            } else {
                if (File::exists($path) === false) {
                    try {
                        $client = Tarpit::client();
                        $res = $client->request(
                            'GET',
                            'https://' . config('tarpit.url') . '/api/' .
                            config('tarpit.version') . '/ip/get'
                        );
                        file_put_contents($path, $res->getBody()->getContents());
                    } catch (\Exception $e) {
                        \Log::error($e->getMessage());
                    }
                } elseif (Carbon::now()->diffInMinutes(Carbon::createFromTimestamp(File::lastModified($path))) > 15) {
                    try {
                        $client = Tarpit::client();
                        $res = $client->request(
                            'GET',
                            'https://' . config('tarpit.url') . '/api/' .
                            config('tarpit.version') . '/ip/get'
                        );
                        file_put_contents($path, $res->getBody()->getContents());
                    } catch (\Exception $e) {
                        \Log::error($e->getMessage());
                    }
                }
                $json = file_get_contents($path);
            }

            if (!isset($json) || empty($json)) {
                return null;
            }

            $array = json_decode($json, true);

            if (is_null($array)) {
                return null;
            }

            if (in_array($params['form_params']['ip'], $array)) {
                return 'https://' . config('tarpit.url') . '/blocked/' . $params['form_params']['from'];
            }
        }

        return null;
    }

    /**
     * @return Client
     */
    public static function client()
    {
        return new Client(
            [
                'headers' => [
                    'User-Agent' => 'TarpitClientBot; Tarpit' . config('tarpit.version') . '; '
                        . str_replace(['http://', 'https://', '/'], '', config('tarpit.domain')),
                ],
                'timeout' => 5
            ]
        );
    }
}
