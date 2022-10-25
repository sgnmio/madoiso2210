<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PutCustomerSettingEndpoint;

class PutCustomerSettingInput extends ApiInput
{
    /**
     * @var int
     */
    public $max_attempts;

    /**
     * @var int
     */
    public $security_level;

    /**
     * @var string
     */
    public static $endpointType = PutCustomerSettingEndpoint::class;
}