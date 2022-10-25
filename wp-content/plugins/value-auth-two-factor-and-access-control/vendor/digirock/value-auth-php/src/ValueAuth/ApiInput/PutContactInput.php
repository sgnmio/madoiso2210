<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PutContactEndpoint;
use ValueAuth\ApiInput\Concerns\HasId;

class PutContactInput extends PostContactInput
{
    use HasId;

    /**
     * @var string
     */
    public static $endpointType = PutContactEndpoint::class;
}
