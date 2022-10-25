<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetContactEndpoint;
use ValueAuth\Enum\SendKbn;

class GetContactInput extends ApiInput
{
    /**
     * @var ?SendKbn
     * @Type('ValueAuth\Enum\SendKbn')
     */
    public $send_kbn;

    /**
     * @var string
     */
    public static $endpointType = GetContactEndpoint::class;
}