<?php
/**
 * File: SoapApiExecutorFactoryTest.php
 * Created at: 2014-12-02 05:32
 */
 
namespace Webit\SoapApi\Tests;

use Webit\SoapApi\SoapApiExecutorFactory;

/**
 * Class SoapApiExecutorFactoryTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class SoapApiExecutorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateApiExecutor()
    {
        $soapClient = $this->getMockBuilder('\SoapClient')->disableOriginalConstructor()->getMock();
        $inputNormalizer = $this->getMock('Webit\SoapApi\Input\InputNormalizerInterface');
        $hydrator = $this->getMock('Webit\SoapApi\Hydrator\HydratorInterface');
        $resultTypeMap = $this->getMock('Webit\SoapApi\ResultType\ResultTypeMapInterface');
        $exceptionFactory = $this->getMock('Webit\SoapApi\Exception\ExceptionFactoryInterface');

        $executorFactory = new SoapApiExecutorFactory();

        $executor = $executorFactory->createExecutor(
            $soapClient,
            $inputNormalizer,
            $hydrator,
            $resultTypeMap,
            $exceptionFactory
        );
        $this->assertInstanceOf('Webit\SoapApi\SoapApiExecutor', $executor);

        $executor = $executorFactory->createExecutor($soapClient, $inputNormalizer, $hydrator, $resultTypeMap);
        $this->assertInstanceOf('Webit\SoapApi\SoapApiExecutor', $executor);

        $executor = $executorFactory->createExecutor($soapClient, $inputNormalizer, $hydrator);
        $this->assertInstanceOf('Webit\SoapApi\SoapApiExecutor', $executor);
    }
}
 