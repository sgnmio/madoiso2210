<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\CountryRestrictionResult;

class PutCountryRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'put';
    public static $path = '/twofactor/oversea/{id}';
    public static $pathParams = ['id'];
    public static $bodyParams = ['customer_key', 'country', 'access_kbn'];
    public static $resultType = CountryRestrictionResult::class;
}