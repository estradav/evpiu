<?php

return [

    'logging' => env('LDAP_LOGGING', true),

    'connections' => [
        'default' => [
            'auto_connect' => env('LDAP_AUTO_CONNECT', true),
            'connection' => Adldap\Connections\Ldap::class,
            'settings' => [
                'schema' => Adldap\Schemas\ActiveDirectory::class,
                'account_prefix' => env('LDAP_ACCOUNT_PREFIX', ''),
                'account_suffix' => env('LDAP_ACCOUNT_SUFFIX', ''),
                'hosts' => explode(' ', env('LDAP_HOSTS', '192.168.1.39')),
                'port' => env('LDAP_PORT', 389),
                'timeout' => env('LDAP_TIMEOUT', 5),
                'base_dn' => env('LDAP_BASE_DN', 'CN=EV-PIU,DC=ciev,DC=local'),
                'username' => env('LDAP_ADMIN_USERNAME', 'cn=administrador,cn=users,dc=ciev,dc=local'),
                'password' => env('LDAP_ADMIN_PASSWORD', '*Estr4d4VM*'),
                'follow_referrals' => env('LDAP_FOLLOW_REFERRALS', true),
                'use_ssl' => env('LDAP_USE_SSL', false),
                'use_tls' => env('LDAP_USE_TLS', false),
            ],
        ],

    ],

];
