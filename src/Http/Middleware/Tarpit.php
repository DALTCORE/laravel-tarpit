<?php

namespace DALTCORE\Tarpit\Http\Middleware;

use Closure;

/**
 * Class Tarpit.
 */
class Tarpit
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('tarpit.enabled') === true) {
            $redirectUrl = \DALTCORE\Tarpit\Services\Tarpit::handler($request, []);
            if ($redirectUrl !== null) {
                return redirect($redirectUrl);
            }
        }

        return $next($request);
    }
}
