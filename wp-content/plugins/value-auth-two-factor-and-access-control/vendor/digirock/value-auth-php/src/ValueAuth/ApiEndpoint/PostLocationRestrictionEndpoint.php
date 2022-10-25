<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\LocationRestrictionResult;

class PostLocationRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'post';
    public static $path = '/twofactor/location';
    public static $bodyParams = ['customer_key', 'location_kbn', 'country', 'state', 'city', 'memo'];
    public static $resultType = LocationRestrictionResult::class;
}