<?php

namespace ValueAuth\ApiResult;

use ValueAuth\Enum\AccessKbn;

class IpAddressRestriction extends Model
{
    /**
     * @var string
     */
    public $ip;

    /**
     * @var AccessKbn
     */
    public $access_kbn;
}