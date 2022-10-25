<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PostIpAddressRestrictionEndpoint;
use ValueAuth\Enum\AccessKbn;

class PostIpAddressRestrictionInput extends ApiInput
{
    /**
     * @var string
     */
    public $ip;

    /**
     * @var AccessKbn
     * @Type('ValueAuth\Enum\AccessKbn')
     */
    public $access_kbn;

    /**
     * @var string
     */
    public static $endpointType = PostIpAddressRestrictionEndpoint::class;
}