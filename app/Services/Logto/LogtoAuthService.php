<?php

namespace App\Services\Logto;

use Logto\Sdk\LogtoClient;
use Logto\Sdk\LogtoConfig;

class LogtoAuthService
{
    public static function run(): LogtoClient
    {
        return new LogtoClient(
            new LogtoConfig(
                endpoint: config('services.logto.endpoint'),
                appId: config('services.logto.app_id'),
                appSecret: config('services.logto.app_secret'),
                scopes: config('services.logto.scopes'),
            ),
            new LogtoStorageService
        );
    }
}
