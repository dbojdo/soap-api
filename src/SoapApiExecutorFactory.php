<?php
/**
 * File: SoapApiExecutorFactory.php
 * Created at: 2014-12-02 05:30
 */
 
namespace Webit\SoapApi;

use Webit\SoapApi\Exception\ExceptionFactoryInterface;
use Webit\SoapApi\Hydrator\HydratorInterface;
use Webit\SoapApi\Input\InputNormalizerInterface;
use Webit\SoapApi\ResultType\ResultTypeMapInterface;

/**
 * Class SoapApiExecutorFactory
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class SoapApiExecutorFactory 
{
    /**
     * @param \SoapClient $soapClient
     * @param InputNormalizerInterface $inputNormalizer
     * @param HydratorInterface $hydrator
     * @param ResultTypeMapInterface $resultTypeMap
     * @param ExceptionFactoryInterface $exceptionFactory
     * @return SoapApiExecutor
     */
    public function createExecutor(
        \SoapClient $soapClient,
        InputNormalizerInterface $inputNormalizer,
        HydratorInterface $hydrator,
        ResultTypeMapInterface $resultTypeMap = null,
        ExceptionFactoryInterface $exceptionFactory = null
    ) {
        return new SoapApiExecutor($soapClient, $inputNormalizer, $hydrator, $resultTypeMap, $exceptionFactory);
    }
}
