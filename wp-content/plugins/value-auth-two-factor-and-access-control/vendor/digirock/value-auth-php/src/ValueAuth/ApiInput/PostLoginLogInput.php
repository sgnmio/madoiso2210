<?php

namespace ValueAuth\ApiInput;

use ValueAuth\ApiEndpoint\PostLoginLogEndpoint;

class PostLoginLogInput extends ApiInput
{
    /**
     * @var bool
     */
    public $is_logged_in;

    /**
     * @var string
     */
    public $login_key;

    /**
     * @var string
     */
    public static $endpointType = PostLoginLogEndpoint::class;
}