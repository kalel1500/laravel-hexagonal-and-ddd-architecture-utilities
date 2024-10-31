
# Formatear los logs como JSON
```php
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'formatter' => Monolog\Formatter\JsonFormatter::class,
        'formatter_with' => [
            'includeStacktraces' => true,
        ],
        'replace_placeholders' => true,
    ],
```