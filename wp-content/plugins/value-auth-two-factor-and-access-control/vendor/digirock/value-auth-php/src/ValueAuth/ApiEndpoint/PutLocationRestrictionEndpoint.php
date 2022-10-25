<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\LocationRestrictionResult;

class PutLocationRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'put';
    public static $path = '/twofactor/location/{id}';
    public static $pathParams = ['id'];
    public static $bodyParams = ['customer_key', 'location_kbn', 'country', 'state', 'city', 'memo'];
    public static $resultType = LocationRestrictionResult::class;
}