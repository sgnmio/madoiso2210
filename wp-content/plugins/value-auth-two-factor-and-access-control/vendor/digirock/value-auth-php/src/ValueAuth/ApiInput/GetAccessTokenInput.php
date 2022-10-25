<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetAccessTokenEndpoint;

class GetAccessTokenInput extends ApiInput
{
    /**
     * @var string
     */
    public $role;

    /**
     * @var string
     */
    public $login_key;

    /**
     * @var string
     */
    public static $endpointType = GetAccessTokenEndpoint::class;
}