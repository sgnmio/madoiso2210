<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PutIpAddressRestrictionEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class PutIpAddressRestrictionInput extends PostIpAddressRestrictionInput
{
    use HasId;

    /**
     * @var string
     */
    public static $endpointType = PutIpAddressRestrictionEndpoint::class;
}