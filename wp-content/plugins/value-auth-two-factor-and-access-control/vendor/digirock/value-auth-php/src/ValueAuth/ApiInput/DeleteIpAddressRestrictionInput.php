<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\DeleteIpAddressRestrictionEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class DeleteIpAddressRestrictionInput extends ApiInput
{
    use HasId;

    /**
     * @var string
     */
    public static $endpointType = DeleteIpAddressRestrictionEndpoint::class;

}