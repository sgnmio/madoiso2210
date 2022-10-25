<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\IpAddressRestrictionResult;

class PostIpAddressRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'post';
    public static $path = '/twofactor/ip';
    public static $queryParams = ['customer_key', 'ip', 'access_kbn'];
    public static $resultType = IpAddressRestrictionResult::class;
}