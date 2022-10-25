<?php

namespace ValueAuth\ApiResult;

class IpAddressRestrictionListResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var IpAddressRestriction[]
     */
    public $customer_ip;
}