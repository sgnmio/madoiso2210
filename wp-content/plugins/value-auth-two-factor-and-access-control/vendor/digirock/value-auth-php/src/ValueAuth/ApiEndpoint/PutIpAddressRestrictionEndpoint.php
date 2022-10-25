<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\IpAddressRestrictionResult;

class PutIpAddressRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'put';
    public static $path = '/twofactor/ip/{id}';
    public static $pathParams = ['id'];
    public static $queryParams = ['customer_key', 'ip', 'access_kbn'];
    public static $resultType = IpAddressRestrictionResult::class;
}