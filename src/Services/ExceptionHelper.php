<?php

namespace DALTCORE\Tarpit\Services;

class ExceptionHelper
{
    /**
     * @param                                     $request
     * @param \Exception                          $exception
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function handleTarpitCommunication($request, \Exception $exception)
    {
        if (config('tarpit.enabled') === true) {
            // Define the response
            $fields = [
                'errors' => 'Sorry, the page you are looking for could not be found.'
            ];

            // Add the exception class name, message and stack trace to response
            $fields['exception'] = get_class($exception); // Reflection might be better here
            $fields['message'] = $exception->getMessage();
            // $fields['trace'] = $exception->getTrace();

            // Default response of 500
            $status = 500;

            // If this exception is an instance of HttpException
            if ($exception instanceof HttpException) {
                // Grab the HTTP status code from the Exception
                $status = $exception->getStatusCode();
            }

            $fields['status'] = $status;

            $redirectUrl = Tarpit::handler($request, $fields);
            if ($redirectUrl !== null) {
                return redirect($redirectUrl);
            }

            /**
             * HTTP Tarpit Helper
             */
            $params = [
                'form_params' => [
                    'type'   => config('tarpit.type'),
                    'ip'     => $request->ip(),
                    'from'   => str_replace(['http://', 'https://', '/'], '', config('tarpit.domain')),
                    'uri'    => $request->server('REQUEST_URI'),
                    'log'    => 1,
                    'fields' => $fields
                ]
            ];

            /**
             * Log users to DB
             */
            try {
                $client = Tarpit::client();
                $request = $client->request('POST', 'https://' . config('tarpit.url') . '/api/' .
                    config('tarpit.version') . '/ip/sync', $params);
                dd($request->getBody()->getContents());
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
    }
}
