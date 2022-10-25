<?php

namespace ValueAuth\ApiResult;

class CountryRestrictionResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var CountryRestriction
     */
    public $customer_oversea;
}