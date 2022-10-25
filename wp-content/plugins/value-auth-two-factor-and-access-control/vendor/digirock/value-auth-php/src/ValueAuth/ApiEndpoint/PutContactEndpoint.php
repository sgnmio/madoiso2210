<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\ContactResult;

class PutContactEndpoint extends ApiEndpoint
{
    public static $method = 'put';
    public static $path = '/twofactor/contact/{id}';
    public static $pathParams = ['id'];
    public static $bodyParams = ['customer_key', 'address', 'send_kbn'];
    public static $resultType = ContactResult::class;
}