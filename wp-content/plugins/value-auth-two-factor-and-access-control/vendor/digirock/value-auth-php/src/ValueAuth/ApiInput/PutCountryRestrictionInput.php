<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PutCountryRestrictionEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class PutCountryRestrictionInput extends PostCountryRestrictionInput
{
    use HasId;

    /**
     * @var string
     */
    public static $endpointType = PutCountryRestrictionEndpoint::class;
}