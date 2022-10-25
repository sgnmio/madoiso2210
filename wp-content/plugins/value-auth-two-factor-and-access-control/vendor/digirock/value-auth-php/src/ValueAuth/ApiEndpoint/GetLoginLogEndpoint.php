<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\LoginLogListResult;

class GetLoginLogEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/twofactor/loginlog';
    public static $queryParams = ['limit', 'page'];
    public static $resultType = LoginLogListResult::class;
}