<?php
/**
 * File: RawExecutorTest.php
 * Created at: 2014-11-25 19:57
 */

namespace Webit\SoapApi\Tests\Executor;

use Webit\SoapApi\Executor\Exception\ExecutorException;
use Webit\SoapApi\Executor\RawExecutor;
use Webit\SoapApi\Tests\AbstractTestCase;

/**
 * Class RawExecutorTest
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class RawExecutorTest extends AbstractTestCase
{
    /**
     * @var \Mockery\MockInterface|\SoapClient
     */
    private $soapClient;

    /**
     * @var RawExecutor
     */
    private $executor;

    private $options = [
        "option_1" => "value_1",
        "option_2" => "value_2",
    ];

    private $headers = [];

    protected function setUp(): void
    {
        $this->headers = [
            new \SoapHeader("namespace", "name", ["some-data" => "some-value"])
        ];

        $this->soapClient = $this->mockSoapClient();

        $this->executor = new RawExecutor($this->soapClient, $this->options, $this->headers);
    }

    /**
     * @test
     */
    public function shouldDelegateToSoapClient()
    {
        $function = 'function';
        $input = array('input' => 'value');
        $result = new \stdClass();

        $this->soapClient->shouldReceive('__soapCall')->with(
            $function,
            $input,
            $this->options,
            $this->headers
        )->andReturn($result);

        $this->assertEquals($result, $this->executor->executeSoapFunction($function, $input));
    }

    /**
     * @test
     */
    public function itMergesDefaultOptionsAndHeadersWithRuntimeOnes()
    {
        $function = 'function';
        $input = array('input' => 'value');
        $result = new \stdClass();
        $customOptions = [
            "option_2" => "value_2_overridden",
            "option_3" => "value_3"
        ];
        $headers = [
            new \SoapHeader("namespace", "custom-header", ["data" => "data"])
        ];

        $this->soapClient->shouldReceive('__soapCall')->with(
            $function,
            $input,
            [
                "option_1" => "value_1",
                "option_2" => "value_2_overridden",
                "option_3" => "value_3"
            ],
            array_merge($this->headers, $headers)
        )->andReturn($result);

        $this->assertSame($result, $this->executor->executeSoapFunction($function, $input, $customOptions, $headers));
    }

    /**
     * @test
     */
    public function shouldWrapAnyExecutionException()
    {
        $this->soapClient->shouldReceive('__soapCall')->andThrow('\SoapFault', 'msg', 23)->once();

        $this->expectException(ExecutorException::class);
        $this->executor->executeSoapFunction('function');
    }
}
