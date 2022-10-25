<?php

namespace ValueAuth\ApiResult;

class LoginLogResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var LoginLog
     */
    public $customer_login_log;
}