<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PutLocationRestrictionEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class PutLocationRestrictionInput extends PostLocationRestrictionInput
{
    use HasId;

    /**
     * @var string
     */
    public static $endpointType = PutLocationRestrictionEndpoint::class;
}