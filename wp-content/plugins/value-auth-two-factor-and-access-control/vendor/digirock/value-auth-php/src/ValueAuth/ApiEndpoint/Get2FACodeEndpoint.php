<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\TwoFactorAuthSendResult;

class Get2FACodeEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/twofactor';
    public static $queryParams = ['customer_key', 'ip'];
    public static $resultType = TwoFactorAuthSendResult::class;
}