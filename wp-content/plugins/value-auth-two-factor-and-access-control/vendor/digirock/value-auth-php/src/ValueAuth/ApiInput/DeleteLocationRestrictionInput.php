<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\DeleteLocationRestrictionEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class DeleteLocationRestrictionInput extends ApiInput
{

    use HasId;

    /**
     * @var string
     */
    public static $endpointType = DeleteLocationRestrictionEndpoint::class;

}