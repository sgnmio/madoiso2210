<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\Post2FACodeEndpoint;

class Post2FACodeInput extends ApiInput
{
    /**
     * @var string
     */
    public $number;

    /**
     * @var string
     */
    public static $endpointType = Post2FACodeEndpoint::class;
}