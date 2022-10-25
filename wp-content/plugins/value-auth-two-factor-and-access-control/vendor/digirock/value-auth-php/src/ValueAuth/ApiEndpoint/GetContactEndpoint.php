<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\ContactResult;

class GetContactEndpoint extends ApiEndpoint
{
    public static $method = 'get';
    public static $path = '/twofactor/contact';
    public static $queryParams = ['customer_key', 'send_kbn'];
    public static $resultType = ContactResult::class;
}