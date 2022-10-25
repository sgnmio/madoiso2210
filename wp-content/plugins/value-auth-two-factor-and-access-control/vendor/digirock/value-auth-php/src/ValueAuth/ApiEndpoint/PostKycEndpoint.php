<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\StringResult;

class PostKycEndpoint extends ApiEndpoint
{
    public static $method = 'post';
    public static $path = '/auth';
    public static $bodyParams = ['address', 'number'];
    public static $resultType = StringResult::class;
}