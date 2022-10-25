<?php

namespace ValueAuth\ApiResult;

class  SiteSetting
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var int
     */
    public $auth_kbn;

    /**
     * @var bool
     */
    public $is_sms_send;


    /**
     * @var bool
     */
    public $is_mail_send;

    /**
     * @var bool
     */
    public $is_location_auth;

    /**
     * @var bool
     */
    public $is_active;

	/**
	 * @var string
	 */
	public $public_key;
}