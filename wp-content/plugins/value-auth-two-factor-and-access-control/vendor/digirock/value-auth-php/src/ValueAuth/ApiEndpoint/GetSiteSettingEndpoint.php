<?php


namespace ValueAuth\ApiEndpoint;


use ValueAuth\ApiResult\SiteSettingResult;
use ValueAuth\Enum\ApiAuthentication;

class GetSiteSettingEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/{auth_code}/sitesetting';
    public static $pathParams = ['auth_code'];
    public static $resultType = SiteSettingResult::class;
    public static $authentication = ApiAuthentication::ApiKey;
}