<?php

namespace ValueAuth\ApiResult;

class LoginLogListResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var LoginLog[]
     */
    public $customer_login_logs;
}