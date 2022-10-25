<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\AccessTokenResult;
use ValueAuth\Enum\ApiAuthentication;

class GetAccessTokenEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/{auth_code}/twofactor/accesstoken';
    public static $pathParams = ['auth_code'];
    public static $queryParams = ['customer_key', 'role', 'login_key'];
    public static $resultType = AccessTokenResult::class;
    public static $authentication = ApiAuthentication::ApiKey;
}