<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\IpAddressRestrictionListResult;

class GetIpAddressRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/twofactor/ip';
    public static $queryParams = ['customer_key'];
    public static $resultType = IpAddressRestrictionListResult::class;
}