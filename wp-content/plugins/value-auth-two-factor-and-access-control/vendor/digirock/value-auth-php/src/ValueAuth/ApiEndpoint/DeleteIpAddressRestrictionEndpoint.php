<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\IpAddressRestrictionResult;

class DeleteIpAddressRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'delete';
    public static $path = '/twofactor/ip/{id}';
    public static $pathParams = ['id'];
    public static $resultType = IpAddressRestrictionResult::class;
}