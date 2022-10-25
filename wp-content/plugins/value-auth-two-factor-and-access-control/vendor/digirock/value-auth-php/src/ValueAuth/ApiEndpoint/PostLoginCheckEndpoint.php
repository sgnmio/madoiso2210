<?php


namespace ValueAuth\ApiEndpoint;


use ValueAuth\ApiResult\LoginCheckResult;
use ValueAuth\Enum\ApiAuthentication;

class PostLoginCheckEndpoint extends ApiEndpoint
{
    public static $method = 'post';
    public static $path = '/{auth_code}/twofactor/checklogin';
    public static $pathParams = ['auth_code'];
    public static $bodyParams = ['customer_key', 'ip', 'user_agent', 'customer_key'];
    public static $authentication = ApiAuthentication::ApiKey;
    public static $resultType = LoginCheckResult::class;
}