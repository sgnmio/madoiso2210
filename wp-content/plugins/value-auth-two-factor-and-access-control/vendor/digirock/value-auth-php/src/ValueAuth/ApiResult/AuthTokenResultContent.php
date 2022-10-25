<?php

namespace ValueAuth\ApiResult;

class AuthTokenResultContent extends ApiResultContent
{
    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $auth_token;
}