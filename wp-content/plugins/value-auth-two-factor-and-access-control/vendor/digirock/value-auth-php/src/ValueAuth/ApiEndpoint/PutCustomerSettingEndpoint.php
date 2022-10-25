<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\CustomerSettingResult;

class PutCustomerSettingEndpoint extends ApiEndpoint
{
    public static $method = 'put';
    public static $path = '/twofactor/setting';
    public static $bodyParams = ['customer_key', 'max_attempts', 'security_level'];
    public static $resultType = CustomerSettingResult::class;
}