<?php

namespace ValueAuth\ApiResult;

class LocationRestrictionResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var LocationRestriction
     */
    public $customer_location;
}