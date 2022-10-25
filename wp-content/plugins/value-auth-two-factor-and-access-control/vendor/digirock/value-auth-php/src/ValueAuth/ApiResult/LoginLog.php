<?php

namespace ValueAuth\ApiResult;

class LoginLog extends Model
{
    /**
     * @var string
     */
    public $ip;

    /**
     * @var string
     */
    public $user_agent;

    /**
     * @var string
     */
    public $address;

    /**
     * @var bool
     */
    public $is_success;

    /**
     * @var string
     */
    public $fraud_point;

    /**
     * @var ?\DateTime
     */
    public $date;
}