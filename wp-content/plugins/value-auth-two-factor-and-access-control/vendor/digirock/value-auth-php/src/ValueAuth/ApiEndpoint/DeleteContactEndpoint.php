<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\ContactResult;

class DeleteContactEndpoint extends ApiEndpoint
{
    public static $method = 'delete';
    public static $path = '/twofactor/contact/{id}';
    public static $pathParams = ['id'];
    public static $queryParams = ['customer_key'];
    public static $resultType = ContactResult::class;
}