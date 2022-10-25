<?php

namespace ValueAuth\ApiResult;

use ValueAuth\Enum\AccessKbn;

class CountryRestriction extends Model
{
    /**
     * @var ?string
     */
    public $country;

    /**
     * @var ?AccessKbn
     */
    public $access_kbn;
}