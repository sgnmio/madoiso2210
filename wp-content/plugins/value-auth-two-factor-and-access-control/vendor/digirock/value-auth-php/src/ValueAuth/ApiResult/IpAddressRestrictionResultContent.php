<?php

namespace ValueAuth\ApiResult;

class IpAddressRestrictionResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var IpAddressRestriction
     */
    public $customer_ip;
}