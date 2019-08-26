<?php

return [
    'path' => [
        'settings' => 'Settings',
        'login' => 'Login and session settings'
    ],
    'le' => [
        'block' => 'On login, allow one request in',
        'blocks' => [
            1 => '1 second',
            2 => '2 seconds',
            3 => '3 seconds',
            4 => '4 seconds',
            5 => '5 seconds'
        ],
        'timer' => 'If not active, blocks the session through',
        'timers' => [
            900 => '15 minutes',
            1800 => '30 minutes',
            3600 => '1 hour',
            7200 => '2 hours',
            14400 => '4 hours'
        ],
        'save-upp' => 'SAVE'
    ]
];
