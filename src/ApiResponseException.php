<?php


namespace H4D\ApiResponse;


class ApiResponseException extends \Exception
{

    /**
     * @param string $key
     * @param array $requiredKeys
     *
     * @return ApiResponseException
     */
    public static function requiredKeyMissing($key, $requiredKeys)
    {
        return new self(sprintf('Required key "%s" is missing! Required keys: %s.',
                               $key, implode(', ', $requiredKeys)));
    }

    /**
     * @param string $key
     * @param string $expectedType
     *
     * @return ApiResponseException
     */
    public static function invalidValueType($key, $expectedType)
    {
        return new self(sprintf('Invalid type for field "%s"! Valid type/s: %s.',
                               $key, $expectedType));
    }

    /**
     * @return ApiResponseException
     */
    public static function invalidCodeValue()
    {
        return new self(sprintf('Invalid "%s" value! Required value: >=%s.',
                                ApiResponse::KEY_CODE, ApiResponse::DEFAULT_SUCCESS_CODE));
    }
}