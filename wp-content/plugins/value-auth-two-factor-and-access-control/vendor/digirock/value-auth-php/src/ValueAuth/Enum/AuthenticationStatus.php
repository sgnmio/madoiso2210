<?php


namespace ValueAuth\Enum;


use MyCLabs\Enum\Enum;
use ValueAuth\ApiResult\ApiError;
use ValueAuth\ApiResult\ApiResult;

class AuthenticationStatus extends Enum
{
    const Failed = "failed";
    const Pending2FA = "pending_2fa";
    const Succeeded = "succeeded";
    const ApiError = "api_error";

    /**
     * @var ApiError | ApiResult
     */
    public $reason;

    /**
     * @var string
     */
    public $accessToken;


}