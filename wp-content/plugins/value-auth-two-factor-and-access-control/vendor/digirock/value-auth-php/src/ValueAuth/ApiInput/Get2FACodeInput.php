<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\Get2FACodeEndpoint;

class Get2FACodeInput extends ApiInput
{
    /**
     * @var ?string
     */
    public $ip;

    /**
     * @var string
     */
    public static $endpointType = Get2FACodeEndpoint::class;

}