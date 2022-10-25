<?php


namespace ValueAuth\ApiInput;


use ValueAuth\ApiEndpoint\GetSiteSettingEndpoint;

class GetSiteSettingInput extends ApiInput
{

    public static $endpointType = GetSiteSettingEndpoint::class;
}