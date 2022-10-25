<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\LocationRestrictionResult;

class DeleteLocationRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'delete';
    public static $path = '/twofactor/location/{id}';
    public static $pathParams = ['id'];
    public static $resultType = LocationRestrictionResult::class;
}