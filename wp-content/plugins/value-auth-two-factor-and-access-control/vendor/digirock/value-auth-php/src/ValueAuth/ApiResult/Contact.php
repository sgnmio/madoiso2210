<?php

namespace ValueAuth\ApiResult;

use ValueAuth\Enum\SendKbn;

class  Contact extends Model
{
    /**
     * @var ?string
     */
    public $address;

    /**
     * @var ?SendKbn
     */
    public $send_kbn;
}