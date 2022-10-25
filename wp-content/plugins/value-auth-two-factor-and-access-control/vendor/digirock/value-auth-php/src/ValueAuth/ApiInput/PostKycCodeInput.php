<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PostKycEndpoint;

class PostKycCodeInput extends ApiInput
{
    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $number;

    /**
     * @var string
     */
    public static $endpointType = PostKycEndpoint::class;
}