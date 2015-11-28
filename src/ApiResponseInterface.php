<?php


namespace H4D\ApiResponse;


interface ApiResponseInterface
{
    /**
     * @return int
     */
    public function getCode();


    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return array
     */
    public function getData();

    /**
     * @return bool
     */
    public function isOK();

    /**
     * @param string $fieldName
     * @param mixed $default
     *
     * @return mixed
     */
    public function getDataField($fieldName, $default = null);

    /**
     * @param array|string $path Array or slash separated values string,
     *                     ie: ['memory', 'total'] or 'memory/total'
     * @param mixed $default
     *
     * @return mixed
     */
    public function getDataPath($path, $default = null);

    /**
     * @param array $array
     *
     * @return ApiResponseInterface
     */
    public function populate(array $array);

    /**
     * @return ApiResponseInterface
     */
    public function reset();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();
}