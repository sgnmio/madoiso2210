<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\AuthTokenResult;

class Post2FACodeEndpoint extends ApiEndpoint
{
    public static $method = 'post';
    public static $path = '/twofactor';
    public static $bodyParams = ['customer_key', 'number'];
    public static $resultType = AuthTokenResult::class;
}