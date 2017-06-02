<?php

namespace DALTCORE\Tarpit;

use DALTCORE\Tarpit\Http\Middleware\Tarpit;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class PackageServiceProvider.
 *
 * @see     http://laravel.com/docs/master/packages#service-providers
 * @see     http://laravel.com/docs/master/providers
 */
class TarpitServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @see http://laravel.com/docs/master/providers#deferred-providers
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Application is booting.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @see http://laravel.com/docs/master/providers#the-boot-method
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerConfigurations();

        $router->aliasMiddleware('tarpit', Tarpit::class);
    }

    /**
     * Register the package configurations.
     *
     * @see http://laravel.com/docs/master/packages#configuration
     *
     * @return void
     */
    protected function registerConfigurations()
    {
        $this->mergeConfigFrom($this->packagePath('config/tarpit.php'), 'tarpit');
        $this->publishes([$this->packagePath('config/config.php') => config_path('tarpit.php')], 'tarpit');
    }

    /**
     * Loads a path relative to the package base directory.
     *
     * @param string $path
     *
     * @return string
     */
    protected function packagePath($path = '')
    {
        return sprintf('%s/../%s', __DIR__, $path);
    }
}
