<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetCountryRestrictionEndpoint;

class GetCountryRestrictionInput extends ApiInput
{
    /**
     * @var string
     */
    public static $endpointType = GetCountryRestrictionEndpoint::class;
}