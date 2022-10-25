<?php

namespace ValueAuth\ApiEndpoint;

use ValueAuth\ApiResult\ContactListResult;

class PostContactEndpoint extends ApiEndpoint
{
    public static $method = 'post';
    public static $path = '/twofactor/contact';
    public static $bodyParams = ['customer_key', 'address', 'send_kbn'];
    public static $resultType = ContactListResult::class;
}