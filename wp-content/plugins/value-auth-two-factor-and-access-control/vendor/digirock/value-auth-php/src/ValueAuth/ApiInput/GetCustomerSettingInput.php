<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetCustomerSettingEndpoint;

class GetCustomerSettingInput extends ApiInput
{

    /**
     * @var string
     */
    public static $endpointType = GetCustomerSettingEndpoint::class;
}