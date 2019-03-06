<?php


return [
    'is_approved' => env('NOT_REQUIRED_REGISTRATION_APPROVAL', true),
	'refer_key_length' => env('REFER_KEY_LENGTH', 10),
    'default_product_image' => env('DEFAULT_PRODUCT_IMAGE', null),
    'social_password' => env('DEFAULT_SOCIAL_PASSWORD', null),
    
	'roles' => [
        [
            'name' => 'Super Admin'
        ],
        [
            'name' => 'Admin'
        ],
        [
            'name' => 'Shopper Team Member'
        ],
        [
            'name' => 'Delivery Team Member'
        ],
        [
            'name' => 'Customer'
        ]
    ],
    'role_id' => 5,
    'permissions' => [
        [
            'name' => 'Super Powers - Super Admin',
        ],
        [
            'name' => 'Manage Users',
        ],
        [
            'name' => 'Manage Branches',
        ],
        [
            'name' => 'Manage Roles',
        ]
    ],
    'users' => [
        [
            'name' => 'Super Admin',
            'email' => 'superadmin@app.com',
            'mobile' => '9999999999',
            'refer_key' => 'super-admin',
            'referred_by_key' => null,
            'password' => 'superadmin',
        ],
        [
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'mobile' => '8888888888',
            'refer_key' => 'admin',
            'referred_by_key' => 'super-admin',
            'password' => 'admin',
        ],
        [
            'name' => 'User',
            'email' => 'user@app.com',
            'mobile' => '7777777777',
            'refer_key' => 'user',
            'referred_by_key' => 'admin',
            'password' => 'user',
        ],
    ]
    
];