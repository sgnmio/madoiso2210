<?php

namespace ValueAuth\ApiResult;

class ContactListResultContent extends ApiResultContent
{
    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var Contact[]
     */
    public $customer_contacts;
}