<?php

namespace ValueAuth\ApiResult;

class CountryRestrictionListResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var CountryRestriction[]
     */
    public $customer_oversea;
}