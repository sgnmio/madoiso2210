<?php


namespace ValueAuth\ApiResult;

use Exception;
use Tebru\Gson\Annotation\Type;

class ApiError
{
    /**
     * @Type("ValueAuth\ApiResult\ApiErrorContent")
     * @var ApiErrorContent
     */
    public $errors;

    public static function fromException(Exception $exception)
    {
        $error = new ApiError();
        $error->errors = new ApiErrorContent();
        $error->errors->code = $exception->getCode();
        $error->errors->message = $exception->getMessage();
        return $error;

    }

}