<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\DeleteCountryRestrictionEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class DeleteCountryRestrictionInput extends ApiInput
{
    use HasId;

    /**
     * @var string
     */
    public static $endpointType = DeleteCountryRestrictionEndpoint::class;

}