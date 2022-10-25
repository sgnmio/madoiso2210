<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\DueDateResult;

class GetKycEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/auth';
    public static $bodyParams = ['send_kbn', 'address', 'ip'];
    public static $resultType = DueDateResult::class;
}