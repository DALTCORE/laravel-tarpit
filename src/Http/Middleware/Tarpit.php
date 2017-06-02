<?php

namespace DALTCORE\Http\Middleware;

use Closure;

/**
 * Class TarpitControl
 *
 * @package App\Http\Middleware
 */
class Tarpit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('tarpitcontrol.enabled') === true) {
            $redirectUrl = Control::handler($request, []);
            if ($redirectUrl !== null) {
                return redirect($redirectUrl);
            }
        }

        return $next($request);
    }
}
