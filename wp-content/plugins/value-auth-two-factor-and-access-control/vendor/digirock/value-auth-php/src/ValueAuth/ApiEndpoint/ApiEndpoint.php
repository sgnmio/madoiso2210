<?php


namespace ValueAuth\ApiEndpoint;


use phpDocumentor\Reflection\Type;
use ValueAuth\Enum\ApiAuthentication;

class ApiEndpoint
{
    /**
     * @var string|null
     */
    public static $method;

    /**
     * @var string|null
     */
    public static $path;

    /**
     * @var string[]
     */
    public static $pathParams = [];

    /**
     * @var string[]
     */
    public static $queryParams = [];

    /**
     * @var string[]
     */
    public static $bodyParams = [];

    /**
     * @var Type
     */
    public static $resultType;

    /**
     * @var string
     */
    public static $authentication = ApiAuthentication::AccessToken;

    public function method(): string
    {
        return static::$method;
    }

    public function path(): string
    {
        return static::$path;
    }

    public function pathParams(): array
    {
        return static::$pathParams;

    }

    public function queryParams(): array
    {
        return static::$queryParams;
    }

    public function bodyParams(): array
    {
        return static::$bodyParams;
    }

    public function resultType(): string
    {
        return static::$resultType;
    }

    public function authentication(): ApiAuthentication
    {
        return new ApiAuthentication(static::$authentication);
    }
}
