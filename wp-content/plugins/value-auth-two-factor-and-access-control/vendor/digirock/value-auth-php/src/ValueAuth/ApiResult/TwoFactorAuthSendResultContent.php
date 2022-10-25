<?php

namespace ValueAuth\ApiResult;

class  TwoFactorAuthSendResultContent extends ApiResultContent
{
    /**
     * @var string
     */
    public $customer_key;

    /**
     * @var string
     */
    public $due_date;
}