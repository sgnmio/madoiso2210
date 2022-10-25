<?php

namespace ValueAuth\ApiResult;

class LocationRestrictionListResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var LocationRestriction[]
     */
    public $customer_locations;
}