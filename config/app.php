<?php

use Illuminate\Support\ServiceProvider;

return [
    'name' => env('APP_NAME', 'ZTAMS'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'Asia/Karachi'),
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'previous_keys' => array_filter(explode(',', (string) env('APP_PREVIOUS_KEYS', ''))),
    'maintenance' => ['driver' => env('APP_MAINTENANCE_DRIVER', 'file'), 'store' => env('APP_MAINTENANCE_STORE', 'database')],
    'providers' => ServiceProvider::defaultProviders()->merge([
        // Application providers are registered in bootstrap/providers.php.
    ])->toArray(),
];
