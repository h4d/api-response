<?php

namespace H4D\ApiResponse;


class ApiResponse implements ApiResponseInterface
{
    // API response fields
    const KEY_CODE    = 'code';
    const KEY_MESSAGE = 'message';
    const KEY_DATA    = 'data';

    // Default API response codes
    const DEFAULT_SUCCESS_CODE = 10000;
    const UNDEFINED_ERROR_CODE = 20000;

    // Default API response messages
    const DEFAULT_SUCCESS_MESSAGE = 'Success!';
    const UNDEFINED_ERROR_MESSAGE = 'Undefined error!';

    /**
     * @var int
     */
    protected $code;
    /**
     * @var string
     */
    protected $message;
    /**
     * @var array
     */
    protected $data;

    /**
     * ApiResponse constructor.
     *
     * @param int $code
     * @param array $data
     * @param string $message
     */
    public function __construct($code = self::DEFAULT_SUCCESS_CODE, $data = [], $message = '')
    {
        $this->setCode($code);
        $this->setData($data);
        $this->setMessage($message);
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return ApiResponse
     * @throws ApiResponseException
     */
    public function setCode($code)
    {
        if (!is_int($code))
        {
            throw ApiResponseException::invalidValueType(self::KEY_CODE, 'int');
        }
        if ($code<self::DEFAULT_SUCCESS_CODE)
        {
            throw ApiResponseException::invalidCodeValue();
        }
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return ApiResponse
     * @throws ApiResponseException
     */
    public function setMessage($message)
    {
        if (!is_string($message))
        {
            throw ApiResponseException::invalidValueType(self::KEY_MESSAGE, 'string');
        }
        $this->message = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return ApiResponse
     * @throws ApiResponseException
     */
    public function setData($data)
    {
        if (!is_array($data))
        {
            throw ApiResponseException::invalidValueType(self::KEY_DATA, 'array');
        }
        $this->data = $data;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOK()
    {
        return (1 == intval($this->getCode()/self::DEFAULT_SUCCESS_CODE));
    }

    /**
     * @param string $fieldName
     * @param mixed $default
     *
     * @return mixed
     */
    public function getDataField($fieldName, $default = null)
    {
        return isset($this->data[$fieldName]) ? $this->data[$fieldName] : $default;
    }

    /**
     * @param string $field
     * @param string|int|float|bool|array|null $value
     *
     * @return $this
     * @throws ApiResponseException
     */
    public function addData($field, $value)
    {
        if (!is_null($value) && !is_int($value)
            && !is_float($value) && !is_string($value) && !is_array($value))
        {
            throw ApiResponseException::invalidValueType($field,
                                                         'string, int, float, bool, array, null');
        }
        $this->data[$field] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [self::KEY_CODE => $this->getCode(),
                self::KEY_MESSAGE => $this->getMessage(),
                self::KEY_DATA => $this->getData()];
    }

}