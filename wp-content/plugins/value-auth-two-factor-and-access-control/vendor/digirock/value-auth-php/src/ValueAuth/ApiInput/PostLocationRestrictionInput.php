<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PostLocationRestrictionEndpoint;
use ValueAuth\Enum\LocationKbn;

class PostLocationRestrictionInput extends ApiInput
{
    /**
     * @var LocationKbn
     */
    public $location_kbn;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $state;

    /**
     * @var ?string
     */
    public $city;

    /**
     * @var ?string
     */
    public $memo;

    /**
     * @var string
     */
    public static $endpointType = PostLocationRestrictionEndpoint::class;
}