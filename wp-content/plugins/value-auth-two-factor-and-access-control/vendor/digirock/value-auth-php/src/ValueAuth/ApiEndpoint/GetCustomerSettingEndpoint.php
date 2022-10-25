<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\CustomerSettingResult;

class GetCustomerSettingEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/twofactor/setting';
    public static $queryParams = ['customer_key'];
    public static $resultType = CustomerSettingResult::class;
}