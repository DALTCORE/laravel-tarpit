# HTTP-Tarpit

HTTP-Tarpit blocklist package for Laravel

## Install

Via Composer

``` bash
$ composer require daltcore/tarpit
```

## Usage

In your `config/app.php` at Service Providers
``` php
DALTCORE\Tarpit\TarpitServiceProvider::class,
```

In your `config/app.php` at Aliasses
``` php
'Tarpit' => DALTCORE\Tarpit\Facade::class,
```

In your `app/Exceptions/Handler.php` under function render() just before `return parent::render($request, $exception);`
``` php
/**
 * Tarpit Exception Helper
 */
\DALTCORE\Tarpit\Services\ExceptionHelper::handleTarpitCommunication($request, $exception);
```

In your `.env` file you have to add the following parameters
```text
# To enable the tarpit
TARPIT_ENABLE=false

# Your website domain
TARPIT_DOMAIN=basis-cms.vm

# Tarpit API Key
TARPIT_API_KEY=af4ae3fe3ff09dbba45a601619ca783455cfeb4d

# Tarpit endpoint
TARPIT_ENDPOINT=api.http-tarpit.org

# Tarpit API Version
TARPIT_VERSION=v2

# Direct sync or with cache (30 minutes)
TARPIT_HANDLER=realtime

```

If you discover any security related issues, please contact [Ramon Smit](https://github.com/ramonsmit).

## Credits

- [RamonSmit](https://github.com/RamonSmit)

## License

The MIT License (MIT). Please see [License File](License.md) for more information.
