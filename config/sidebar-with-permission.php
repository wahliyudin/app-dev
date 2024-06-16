<?php

return [
    'sidebars' => [
        [
            'title' => 'DASHBOARD',
            'child' => [
                [
                    'title' => 'DASHBOARD',
                    'permissions' => 'r',
                ],
            ]
        ],
        [
            'title' => 'SETTING',
            'child' => [
                [
                    'title' => 'APPROVAL',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'ACCESS PERMISSION',
                    'permissions' => 'r,u',
                ],
            ]
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'approv' => 'approv',
        'reject' => 'reject',
        'report' => 'report',
        'list' => 'list',
    ]
];
