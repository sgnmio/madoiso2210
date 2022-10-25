<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\DeleteContactEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class DeleteContactInput extends ApiInput
{
    use HasId;

    /**
     * @var string
     */
    public static $endpointType = DeleteContactEndpoint::class;
}