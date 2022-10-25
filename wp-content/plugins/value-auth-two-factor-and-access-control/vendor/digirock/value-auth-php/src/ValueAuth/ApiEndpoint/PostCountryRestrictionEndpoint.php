<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\CountryRestrictionResult;

class PostCountryRestrictionEndpoint extends ApiEndpoint
{
    public static $method = 'post';
    public static $path = '/twofactor/oversea';
    public static $bodyParams = ['customer_key', 'country', 'access_kbn'];
    public static $resultType = CountryRestrictionResult::class;
}