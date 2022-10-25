<?php


namespace ValueAuth\ApiResult;


class LoginCheckResultContent extends ApiResultContent
{
    /**
     * @var string
     */
    public $login_key;

    /**
     * @var int
     */
    public $point;

}