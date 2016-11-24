<?php


namespace H4D\ApiResponse\Tests\Unit;


use H4D\ApiResponse\ApiResponse;
use H4D\ApiResponse\ApiResponseFactory;

class ApiResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_getInstance_resturnProperInstance()
    {
        $factory = ApiResponseFactory::getInstance();
        $this->assertTrue($factory instanceof ApiResponseFactory);
        $factory2 = ApiResponseFactory::getInstance();
        $this->assertSame($factory, $factory2);
    }

    public function test_i_resturnProperInstance()
    {
        $factory = ApiResponseFactory::i();
        $this->assertTrue($factory instanceof ApiResponseFactory);
    }

    /**
     * @depends test_i_resturnProperInstance
     */
    public function test_fromArray_withProperParams_returnsProperApiResponse()
    {
        $code = 25000;
        $msg = 'Msg';
        $data = [1, 2, 3];
        $foo = [ApiResponse::KEY_CODE => $code, ApiResponse::KEY_MESSAGE => $msg,
                ApiResponse::KEY_DATA => $data];
        $response = ApiResponseFactory::i()->fromArray($foo);
        $this->assertTrue($response instanceof ApiResponse);
        $this->assertEquals($code, $response->getCode());
        $this->assertEquals($msg, $response->getMessage());
        $this->assertEquals($data, $response->getData());

    }

    /**
     * @expectedException \H4D\ApiResponse\ApiResponseException
     * @depends test_i_resturnProperInstance
     */
    public function test_fromArray_withIncompleteArray_throwsException()
    {
        $code = 25000;
        $msg = 'Msg';
        $foo = [ApiResponse::KEY_CODE => $code, ApiResponse::KEY_MESSAGE => $msg];
        ApiResponseFactory::i()->fromArray($foo);
    }
}