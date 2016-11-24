<?php


namespace H4D\ApiResponse\Tests\Unit;


use H4D\ApiResponse\ApiResponse;

class ApiResponseTest extends \PHPUnit_Framework_TestCase
{

    use PrivateAccessTrait;

    public function test_constructor_withNoParams_returnsProperInstance()
    {
        $response = new ApiResponse();
        $this->assertTrue($response instanceof ApiResponse);
        $this->assertEquals(ApiResponse::DEFAULT_SUCCESS_CODE, $response->getCode());
        $this->assertEquals([], $response->getData());
        $this->assertEquals('', $response->getMessage());
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_setCode_withProperCode_setsCodeProperly()
    {
        $response = new ApiResponse();
        $code = 1212121;
        $response->setCode($code);
        $this->assertEquals($code, $this->getNonPublicPropertyValue($response, 'code'));
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     * @expectedException \H4D\ApiResponse\ApiResponseException
     */
    public function test_setCode_withNonIntCode_throwsException()
    {
        $response = new ApiResponse();
        $response->setCode('A');
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     * @expectedException \H4D\ApiResponse\ApiResponseException
     */
    public function test_setCode_withInvalidIntCode_throwsException()
    {
        $response = new ApiResponse();
        $response->setCode(999);
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_setMessage_withProperMessage_setsCodeProperly()
    {
        $response = new ApiResponse();
        $message = 'Hello world!';
        $response->setMessage($message);
        $this->assertEquals($message, $this->getNonPublicPropertyValue($response, 'message'));
    }

    public function badMessagesProvider()
    {
        return [
            [null],
            [[]],
            [1],
            [1.3], [new \DateTime()]
        ];
    }

    /**
     * @dataProvider badMessagesProvider
     * @depends      test_constructor_withNoParams_returnsProperInstance
     * @expectedException \H4D\ApiResponse\ApiResponseException
     *
     * @param mixed $message
     */
    public function test_setMessage_withNonStringMessage_throwsException($message)
    {
        $response = new ApiResponse();
        $response->setMessage($message);
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_setData_withProperData_setsCodeProperly()
    {
        $response = new ApiResponse();

        $data = null;
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

        $data = 10;
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

        $data = 1.0;
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

        $data = true;
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

        $data = 'Hello';
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

        $data = [];
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

        $data = [1, 2, 3, 'A', true, 1.0];
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

        $data = ['A' => 1, 'B' => 'b'];
        $response->setData($data);
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     * @expectedException \H4D\ApiResponse\ApiResponseException
     */
    public function test_setData_withInvalidData_throwsException()
    {
        $response = new ApiResponse();
        $response->setData(new \DateTime());
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_addData_withProperValue_addsDataProperly()
    {
        $response = new ApiResponse();
        $response->addData('A', 'B');
        $this->assertEquals(['A' => 'B'], $this->getNonPublicPropertyValue($response, 'data'));

        $response->addData('C', 'D');
        $this->assertEquals(['A' => 'B', 'C' => 'D'],
                            $this->getNonPublicPropertyValue($response, 'data'));

        $response->addData('E', [1, 2, 3]);
        $this->assertEquals(['A' => 'B', 'C' => 'D', 'E' => [1, 2, 3]],
                            $this->getNonPublicPropertyValue($response, 'data'));
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     * @expectedException \H4D\ApiResponse\ApiResponseException
     */
    public function test_addData_withInvalidValue_throwsException()
    {
        $response = new ApiResponse();
        $response->addData('A', new \DateTime());
    }
    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_reset()
    {
        $response = new ApiResponse(52222, ['one' => 1], 'Test message');
        $response->reset();
        $this->assertEquals(new ApiResponse(), $response);
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_toJson_returnsProperJson()
    {
        $response = new ApiResponse(52222, ['one' => 1], 'Test message');
        $expected = '{"code":52222,"message":"Test message","data":{"one":1}}';
        $this->assertEquals($expected, $response->toJson());

        $response = new ApiResponse(52222, true, 'Test message');
        $expected = '{"code":52222,"message":"Test message","data":true}';
        $this->assertEquals($expected, $response->toJson());

        $response = new ApiResponse(52222, 1, 'Test message');
        $expected = '{"code":52222,"message":"Test message","data":1}';
        $this->assertEquals($expected, $response->toJson());

        $response = new ApiResponse(52222, 'data', 'Test message');
        $expected = '{"code":52222,"message":"Test message","data":"data"}';
        $this->assertEquals($expected, $response->toJson());

        $response = new ApiResponse(52222, null, 'Test message');
        $expected = '{"code":52222,"message":"Test message","data":null}';
        $this->assertEquals($expected, $response->toJson());
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_toArray_returnsProperArray()
    {
        $response = new ApiResponse(52222, ['one' => 1], 'Test message');
        $expected = ['code' => 52222, 'message' => 'Test message', 'data' => ['one' => 1]];
        $this->assertEquals($expected, $response->toArray());

        $response = new ApiResponse(52222, true, 'Test message');
        $expected = ['code' => 52222, 'message' => 'Test message', 'data' => true];
        $this->assertEquals($expected, $response->toArray());

        $response = new ApiResponse(52222, 1, 'Test message');
        $expected = ['code' => 52222, 'message' => 'Test message', 'data' => 1];
        $this->assertEquals($expected, $response->toArray());

        $response = new ApiResponse(52222, 'data', 'Test message');
        $expected = ['code' => 52222, 'message' => 'Test message', 'data' => 'data'];
        $this->assertEquals($expected, $response->toArray());

        $response = new ApiResponse(52222, null, 'Test message');
        $expected = ['code' => 52222, 'message' => 'Test message', 'data' => null];
        $this->assertEquals($expected, $response->toArray());
    }


    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_isOK_restursProperValues()
    {
        $code = 10000;
        $response = new ApiResponse($code);
        $this->assertTrue($response->isOK());

        $code = 19999;
        $response = new ApiResponse($code);
        $this->assertTrue($response->isOK());

        $code = 20000;
        $response = new ApiResponse($code);
        $this->assertFalse($response->isOK());

        $code = 560000;
        $response = new ApiResponse($code);
        $this->assertFalse($response->isOK());

    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     * @depends test_setData_withProperData_setsCodeProperly
     */
    public function test_getDataField_worksProperly()
    {
        $response = new ApiResponse();

        $response->setData(true);
        $this->assertEquals(null, $response->getDataField('foo'));
        $this->assertEquals('A', $response->getDataField('foo', 'A'));

        $response->setData(['foo'=>'bar']);
        $this->assertEquals('bar', $response->getDataField('foo'));
        $this->assertEquals('bar', $response->getDataField('foo', 'A'));
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     * @depends test_setData_withProperData_setsCodeProperly
     */
    public function test_getDataPath_worksProperly()
    {
        $response = new ApiResponse();

        $this->assertEquals(null, $response->getDataPath('foo/bar'));
        $this->assertEquals('A', $response->getDataField('foo/bar', 'A'));

        $response->setData(['foo'=>['bar'=>'data']]);
        $this->assertEquals(['bar'=>'data'], $response->getDataPath('foo'));
        $this->assertEquals('data', $response->getDataPath('foo/bar'));
        $this->assertEquals('data', $response->getDataPath(['foo', 'bar']));
        $this->assertEquals('data', $response->getDataPath('foo/bar', 'A'));
        $this->assertEquals('data', $response->getDataPath(['foo', 'bar'], 'A'));
    }

    /**
     * @depends test_constructor_withNoParams_returnsProperInstance
     */
    public function test_populate_withProperData_populatesResponseProperly()
    {
        $response = new ApiResponse();
        $code = 100000;
        $message = 'Test message!';
        $data = 'Test data';
        $foo = [ApiResponse::KEY_CODE=>$code,
                ApiResponse::KEY_DATA=>$data,
                ApiResponse::KEY_MESSAGE=>$message,
                'Other' => 'AA'];

        $response->populate($foo);
        $this->assertEquals($code, $this->getNonPublicPropertyValue($response, 'code'));
        $this->assertEquals($message, $this->getNonPublicPropertyValue($response, 'message'));
        $this->assertEquals($data, $this->getNonPublicPropertyValue($response, 'data'));

    }

}