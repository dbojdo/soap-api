<?php
/**
 * File: SoapApiExecutor.php
 * Created at: 2014-11-25 18:29
 */

namespace Webit\SoapApi;

use Webit\SoapApi\Exception\ExceptionFactoryInterface;
use Webit\SoapApi\Exception\ExecutorException;
use Webit\SoapApi\Hydrator\Exception\HydrationException;
use Webit\SoapApi\Input\Exception\NormalizationException;
use Webit\SoapApi\Hydrator\HydratorInterface;
use Webit\SoapApi\Input\InputNormalizerInterface;
use Webit\SoapApi\ResultType\ResultTypeMapInterface;

/**
 * Class SoapApiExecutor
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class SoapApiExecutor implements SoapApiExecutorInterface
{
    /**
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * @var InputNormalizerInterface
     */
    private $inputNormalizer;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var ResultTypeMapInterface
     */
    private $resultTypeMap;

    /**
     * @var ExceptionFactoryInterface
     */
    private $exceptionFactory;

    /**
     * @param \SoapClient $soapClient
     * @param InputNormalizerInterface $inputNormalizer
     * @param HydratorInterface $hydrator
     * @param ResultTypeMapInterface $resultTypeMap
     * @param ExceptionFactoryInterface $exceptionFactory
     */
    public function __construct(
        \SoapClient $soapClient,
        InputNormalizerInterface $inputNormalizer,
        HydratorInterface $hydrator = null,
        ResultTypeMapInterface $resultTypeMap = null,
        ExceptionFactoryInterface $exceptionFactory = null
    ) {
        $this->soapClient = $soapClient;
        $this->inputNormalizer = $inputNormalizer;
        $this->hydrator = $hydrator;
        $this->resultTypeMap = $resultTypeMap;
        $this->exceptionFactory = $exceptionFactory;
    }

    /**
     * @param string $soapFunction
     * @param mixed $input
     * @param string $resultType
     * @throws HydrationException
     * @throws NormalizationException
     * @throws \Exception
     * @return mixed
     */
    public function executeSoapFunction($soapFunction, $input = null, $resultType = null)
    {
        try {
            $input = $this->inputNormalizer->normalizeInput($soapFunction, $input);
            $result = $this->soapClient->__soapCall($soapFunction, $input);

            $resultType = ! $resultType && $this->resultTypeMap
                            ? $this->resultTypeMap->getResultType($soapFunction)
                            : $resultType;

            if (! $resultType) {
                return $result;
            }

            if ($resultType && ! $this->hydrator) {
                throw new ExecutorException(
                    sprintf('Result type "%s" has been required but Hydrator has not been set', $resultType)
                );
            }

            return $this->hydrator->hydrateResult($result, $resultType);
        } catch (HydrationException $e) {
            throw $e;
        } catch (NormalizationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $this->exceptionFactory
                ? $this->exceptionFactory->createException($e, $soapFunction, $input)
                : $e;
        }
    }
}
