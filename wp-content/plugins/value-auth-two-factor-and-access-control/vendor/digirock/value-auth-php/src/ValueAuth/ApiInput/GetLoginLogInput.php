<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetLoginLogEndpoint;
use ValueAuth\ApiInput\Concerns\HasPaging;

class GetLoginLogInput extends ApiInput
{
    use HasPaging;

    /**
     * @var string
     */
    public static $endpointType = GetLoginLogEndpoint::class;
}