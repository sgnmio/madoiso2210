<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetLocationRestrictionEndpoint;

class GetLocationRestrictionInput extends ApiInput
{
    /**
     * @var string
     */
    public static $endpointType = GetLocationRestrictionEndpoint::class;
}