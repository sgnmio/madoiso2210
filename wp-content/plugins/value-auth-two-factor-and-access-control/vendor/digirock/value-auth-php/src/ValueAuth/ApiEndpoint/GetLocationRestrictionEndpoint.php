<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\LocationRestrictionListResult;

class GetLocationRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/twofactor/location';
    public static $queryParams = ['customer_key'];
    public static $resultType = LocationRestrictionListResult::class;
}