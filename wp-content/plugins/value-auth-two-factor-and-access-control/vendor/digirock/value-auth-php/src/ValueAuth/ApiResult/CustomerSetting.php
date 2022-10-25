<?php

namespace ValueAuth\ApiResult;

class CustomerSetting extends Model
{

    /**
     * @var int
     */
    public $max_attempts;

    /**
     * @var int
     */
    public $security_level;
}