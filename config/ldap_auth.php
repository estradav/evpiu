<?php

use http\Client\Curl\User;

return [

    'connection' => env('LDAP_CONNECTION', 'default'),

    'provider' => Adldap\Laravel\Auth\DatabaseUserProvider::class,

    'model' => App\User::class,

    'rules' => [
        Adldap\Laravel\Validation\Rules\DenyTrashed::class,
    ],

    'scopes' => [
        App\Scopes\EvpiuScope::class,
    ],

    'identifiers' => [
        'ldap' => [
            'locate_users_by' => 'sAMAccountName',
            'bind_users_by' => 'distinguishedname',
        ],

        'database' => [
            'guid_column' => 'objectguid',
            'username_column' => 'username',
        ],

        'windows' => [
            'locate_users_by' => 'cn',
            'server_key' => 'AUTH_USER',
        ],

    ],

    'passwords' => [
        'sync' => env('LDAP_PASSWORD_SYNC', true),
        'column' => 'password',
    ],

    'login_fallback' => env('LDAP_LOGIN_FALLBACK', true),


    /*Atributos que se quieren sincronizar con el directorio activo a la derecha el campo del AD
    y a la izquierda el campo de la base de datos local (EVPIU) */
    'sync_attributes' => [
        'username' => 'sAMAccountName',
        'name' => 'cn',
        'email' => 'mail',
        'app_roll'  => 'title'
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | User authentication attempts will be logged using Laravel's
    | default logger if this setting is enabled.
    |
    | No credentials are logged, only usernames.
    |
    | This is usually stored in the '/storage/logs' directory
    | in the root of your application.
    |
    | This option is useful for debugging as well as auditing.
    |
    | You can freely remove any events you would not like to log below,
    | as well as use your own listeners if you would prefer.
    |
    */

    'logging' => [

        'enabled' => env('LDAP_LOGGING', true),

        'events' => [

            \Adldap\Laravel\Events\Importing::class                 => \Adldap\Laravel\Listeners\LogImport::class,
            \Adldap\Laravel\Events\Synchronized::class              => \Adldap\Laravel\Listeners\LogSynchronized::class,
            \Adldap\Laravel\Events\Synchronizing::class             => \Adldap\Laravel\Listeners\LogSynchronizing::class,
            \Adldap\Laravel\Events\Authenticated::class             => \Adldap\Laravel\Listeners\LogAuthenticated::class,
            \Adldap\Laravel\Events\Authenticating::class            => \Adldap\Laravel\Listeners\LogAuthentication::class,
            \Adldap\Laravel\Events\AuthenticationFailed::class      => \Adldap\Laravel\Listeners\LogAuthenticationFailure::class,
            \Adldap\Laravel\Events\AuthenticationRejected::class    => \Adldap\Laravel\Listeners\LogAuthenticationRejection::class,
            \Adldap\Laravel\Events\AuthenticationSuccessful::class  => \Adldap\Laravel\Listeners\LogAuthenticationSuccess::class,
            \Adldap\Laravel\Events\DiscoveredWithCredentials::class => \Adldap\Laravel\Listeners\LogDiscovery::class,
            \Adldap\Laravel\Events\AuthenticatedWithWindows::class  => \Adldap\Laravel\Listeners\LogWindowsAuth::class,
            \Adldap\Laravel\Events\AuthenticatedModelTrashed::class => \Adldap\Laravel\Listeners\LogTrashedModel::class,

        ],
    ],

];
