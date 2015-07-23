<?php
return [
    'service_manager' => [
        'invokables' => [
            'logger-listener' => 'Logger\Listener\LogListener',
        ],
        'services' => [
            'logger-params' => [
                'dir' => __DIR__ . '/../../../data/logs',
            ],
        ],
    ],  
    'listeners' => [
        'logger-listener',
    ],
];
