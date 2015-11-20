<?php


namespace H4D\ApiResponse;


class ApiResponseFactory
{

    /**
     * @var ApiResponseFactory
     */
    protected static $instance;

    /**
     * ApiResponseFactory constructor.
     */
    protected function __construct() {}

    /**
     * @return ApiResponseFactory
     */
    public static function i()
    {
        return self::getInstance();
    }

    /**
     * @return ApiResponseFactory
     */
    public static function getInstance()
    {
        if (false == self::$instance instanceof ApiResponseFactory)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array $data
     *
     * @return ApiResponse
     * @throws ApiResponseException
     */
    public function fromArray(array $data)
    {
        $requiredKeys = [ApiResponse::KEY_CODE, ApiResponse::KEY_DATA, ApiResponse::KEY_MESSAGE];
        foreach($requiredKeys as $requiredKey)
        {
            if (!isset($data[$requiredKey]))
            {
                throw ApiResponseException::requiredKeyMissing($requiredKey, $requiredKeys);
            }
        }

        return new ApiResponse($data[ApiResponse::KEY_CODE],
                               $data[ApiResponse::KEY_DATA],
                               $data[ApiResponse::KEY_MESSAGE]);
    }
}