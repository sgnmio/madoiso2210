<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetIpAddressRestrictionEndpoint;

class GetIpAddressRestrictionInput extends ApiInput
{

    /**
     * @var string
     */
    public static $endpointType = GetIpAddressRestrictionEndpoint::class;
}