<?php

namespace ValueAuth\ApiResult;

class CustomerSettingResultContent extends ApiResultContent
{

    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var CustomerSetting
     */
    public $customer_setting;
}