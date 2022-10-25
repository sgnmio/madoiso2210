<?php


namespace ValueAuth\ApiInput;


use ValueAuth\ApiEndpoint\PostLoginCheckEndpoint;

class PostLoginCheckInput extends ApiInput
{
    /**
     * @var string
     */
    public $ip;

    /**
     * @var string
     */
    public $user_agent;

    /**
     * @var string
     */
    public $customer_key;

    /**
     * @var string
     */
    public static $endpointType= PostLoginCheckEndpoint::class;
}