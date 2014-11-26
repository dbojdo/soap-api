<?php
/**
 * File: SoapApiExecutorTest.php
 * Created at: 2014-11-25 19:57
 */

namespace Webit\SoapApi\Tests;

use Webit\SoapApi\Exception\ExceptionFactoryInterface;
use Webit\SoapApi\Exception\ExecutorException;
use Webit\SoapApi\Hydrator\Exception\HydrationException;
use Webit\SoapApi\Hydrator\HydratorInterface;
use Webit\SoapApi\Input\InputNormalizerInterface;
use Webit\SoapApi\ResultType\ResultTypeMapInterface;
use Webit\SoapApi\SoapApiExecutor;

/**
 * Class SoapApiExecutorTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class SoapApiExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldExecuteSoapFunction()
    {
        $function = 'test-function';
        $input = array();
        $result = new \stdClass();

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->once())
            ->method('__soapCall')
            ->with($this->equalTo($function), $this->equalTo($input))
            ->willReturn($result);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->any())->method('normalizeInput')->willReturn($input);

        $executor = new SoapApiExecutor($soapClient, $normalizer);

        $soapResult = $executor->executeSoapFunction($function, $input);
        $this->assertSame($result, $soapResult);
    }

    /**
     * @test
     */
    public function shouldNormalizeInputWithNormalizer()
    {
        $function = 'test-function';
        $input = array();
        $result = new \stdClass();

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->once())
                    ->method('__soapCall')
                    ->willReturn($result);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->once())->method('normalizeInput')
                    ->with($this->equalTo($function), $this->equalTo($input))
                    ->willReturn($input);

        $executor = new SoapApiExecutor($soapClient, $normalizer);
        $executor->executeSoapFunction($function, $input);
    }

    /**
     * @test
     * @throws \Exception
     * @throws \Webit\SoapApi\HydrationException
     * @throws \Webit\SoapApi\NormalizationException
     */
    public function shouldDelegateChoosingResultTypeToResultTypeMapIfPassedEmptyResultType()
    {
        $function = 'test-function';
        $input = array();
        $result = new \stdClass();

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->any())
            ->method('__soapCall')
            ->willReturn($result);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->any())->method('normalizeInput')
            ->willReturn($input);

        $hydrator = $this->getHydrator();

        $resultTypeMap = $this->createResultTypeMap();
        $resultTypeMap->expects($this->never())->method('getResultType');

        $executor = new SoapApiExecutor($soapClient, $normalizer, $hydrator, $resultTypeMap);
        $executor->executeSoapFunction($function, $input, 'array');

        $resultTypeMap = $this->createResultTypeMap();
        $resultTypeMap->expects($this->once())->method('getResultType')->with($this->equalTo($function));

        $executor = new SoapApiExecutor($soapClient, $normalizer, $hydrator, $resultTypeMap);
        $executor->executeSoapFunction($function, $input);
    }

    /**
     * @test
     */
    public function shouldDelegateHydrationToHydratorIfSetAndResultTypeIsGiven()
    {
        $function = 'test-function';
        $input = array();
        $result = new \stdClass();

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->any())
            ->method('__soapCall')
            ->willReturn($result);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->any())->method('normalizeInput')
            ->willReturn($input);

        $hydrator = $this->getHydrator();
        $hydrationResult = new \stdClass();

        $hydrationResult->yyy = 'zzz';
        $hydrator->expects($this->once())
                    ->method('hydrateResult')
                    ->with($this->equalTo($result), $this->equalTo('array'))
                    ->willReturn($hydrationResult);

        $executor = new SoapApiExecutor($soapClient, $normalizer, $hydrator);
        $result = $executor->executeSoapFunction($function, $input, 'array');
        $this->assertSame($hydrationResult, $result);
    }

    /**
     * @test
     * @expectedException \Webit\SoapApi\Exception\ExecutorException
     * @throws \Exception
     * @throws \Webit\SoapApi\HydrationException
     * @throws \Webit\SoapApi\NormalizationException
     */
    public function shouldThrowExceptionIfResultTypeIsSetButThereIsNoHydrator()
    {
        $function = 'test-function';
        $input = array();
        $result = new \stdClass();

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->any())
            ->method('__soapCall')
            ->willReturn($result);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->any())->method('normalizeInput')
            ->willReturn($input);

        $executor = new SoapApiExecutor($soapClient, $normalizer);
        $executor->executeSoapFunction($function, $input, 'array');
    }

    /**
     * @test
     * @expectedException \Webit\SoapApi\Hydrator\Exception\HydrationException
     * @throws \Exception
     * @throws \Webit\SoapApi\HydrationException
     * @throws \Webit\SoapApi\NormalizationException
     */
    public function shouldThrowHydrationException()
    {
        $function = 'test-function';
        $input = array();
        $result = new \stdClass();

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->any())
            ->method('__soapCall')
            ->willReturn($result);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->any())->method('normalizeInput')
            ->willReturn($input);

        $hydrator = $this->getHydrator();
        $hydrator->expects($this->any())
            ->method('hydrateResult')
            ->willThrowException(
                $this->getMock('Webit\SoapApi\Hydrator\Exception\HydrationException')
            );

        $executor = new SoapApiExecutor($soapClient, $normalizer, $hydrator);
        $executor->executeSoapFunction($function, $input, 'array');
    }

    /**
     * @test
     * @expectedException \Webit\SoapApi\Input\Exception\NormalizationException
     * @throws \Exception
     * @throws \Webit\SoapApi\HydrationException
     * @throws \Webit\SoapApi\NormalizationException
     */
    public function shouldThrowNormalizationException()
    {
        $function = 'test-function';
        $input = array();
        $result = new \stdClass();

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->any())
            ->method('__soapCall')
            ->willReturn($result);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->any())->method('normalizeInput')
            ->willThrowException($this->getMock('Webit\SoapApi\Input\Exception\NormalizationException'));

        $executor = new SoapApiExecutor($soapClient, $normalizer);
        $executor->executeSoapFunction($function, $input);
    }

    /**
     * @test
     */
    public function shouldDelegateExceptionWrappingToFactoryIfIsSet()
    {
        $function = 'test-function';
        $input = array();

        $e = $this->getMock('\Exception');

        $soapClient = $this->createSoapClient();
        $soapClient->expects($this->any())
            ->method('__soapCall')
            ->willThrowException($e);

        $normalizer = $this->createNormalizer();
        $normalizer->expects($this->any())->method('normalizeInput')
            ->willReturn($input);

        $exceptionFactory = $this->createExceptionFactory();
        $exceptionFactory->expects($this->once())
                        ->method('createException')
                        ->with($this->equalTo($e),$this->equalTo($function), $this->equalTo($input))
                        ->willReturn($this->getMock('\Exception'));

        $executor = new SoapApiExecutor($soapClient, $normalizer, null, null, $exceptionFactory);
        try {
            $executor->executeSoapFunction($function, $input);
        } catch (\Exception $catchedE) {
            $this->assertNotSame($e, $catchedE);
        }
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SoapClient
     */
    private function createSoapClient()
    {
        $soapClient = $this->getMockBuilder('\SoapClient')->disableOriginalConstructor()->getMock();

        return $soapClient;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|InputNormalizerInterface
     */
    private function createNormalizer()
    {
        $normalizer = $this->getMock('Webit\SoapApi\Input\InputNormalizerInterface');

        return $normalizer;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ResultTypeMapInterface
     */
    private function createResultTypeMap()
    {
        $resultTypeMap = $this->getMock('Webit\SoapApi\ResultType\ResultTypeMapInterface');

        return $resultTypeMap;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|HydratorInterface
     */
    private function getHydrator()
    {
        $resultTypeMap = $this->getMock('Webit\SoapApi\Hydrator\HydratorInterface');

        return $resultTypeMap;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ExceptionFactoryInterface
     */
    private function createExceptionFactory()
    {
        $exceptionFactory = $this->getMock('Webit\SoapApi\Exception\ExceptionFactoryInterface');

        return $exceptionFactory;
    }
}
