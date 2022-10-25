<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\CountryRestrictionResult;

class DeleteCountryRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'delete';
    public static $path = '/twofactor/oversea/{id}';
    public static $pathParams = ['id'];
    public static $resultType = CountryRestrictionResult::class;
}