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
            'title' => 'REQUEST',
            'label' => 'REQUEST',
            'permissions' => 'c,r,u,d,approve,reject',
        ],
        [
            'title' => 'APPLICATION',
            'child' => [
                [
                    'title' => 'TASK',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'FEATURE',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'FILE',
                    'permissions' => 'r',
                ],
                [
                    'title' => 'DEVELOPER',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'SETTING',
                    'permissions' => 'r,u',
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
    'roles' => [
        'user',
        'administrator',
        'developer',
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'approve' => 'approve',
        'reject' => 'reject',
        'report' => 'report',
        'list' => 'list',
    ]
];
