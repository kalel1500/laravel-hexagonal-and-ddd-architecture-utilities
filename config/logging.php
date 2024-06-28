<?php

return [
    'channels' => [
        'queues' => [
            'driver' => 'single',
            'path' => storage_path('logs/queues.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'loads' => [
            'driver' => 'single',
            'path' => storage_path('logs/loads.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],
    ],

];
