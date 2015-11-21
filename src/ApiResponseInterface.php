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
     * @param array $array
     *
     * @return mixed
     */
    public function populate(array $array);

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();
}