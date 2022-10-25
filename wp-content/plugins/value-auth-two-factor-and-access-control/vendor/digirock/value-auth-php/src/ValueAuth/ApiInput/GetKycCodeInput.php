<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\GetKycEndpoint;
use ValueAuth\Enum\SendKbn;

class GetKycCodeInput extends ApiInput
{
    /**
     * @var SendKbn
     * @Type('ValueAuth\Enum\SendKbn')
     */
    public $send_kbn;

    /**
     * @var string
     */
    public $address;

    /**
     * @var ?string
     */
    public $ip;

    /**
     * @var string
     */
    public static $endpointType = GetKycEndpoint::class;
}