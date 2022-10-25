<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PostCountryRestrictionEndpoint;
use ValueAuth\Enum\AccessKbn;

class PostCountryRestrictionInput extends ApiInput
{
    /**
     * @var string
     */
    public $country;
    /**
     * @var AccessKbn
     */
    public $access_kbn;

    /**
     * @var string
     */
    public static $endpointType = PostCountryRestrictionEndpoint::class;
}