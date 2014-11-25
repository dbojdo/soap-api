<?php
/**
 * AbstractApi.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 15:55
 */

namespace Webit\SoapApi;

use Webit\SoapApi\Exception\ExceptionFactoryInterface;
use Webit\SoapApi\Hydrator\Exception\HydrationException;
use Webit\SoapApi\Hydrator\HydratorInterface;
use Webit\SoapApi\Input\Exception\NormalizationException;
use Webit\SoapApi\Input\InputNormalizerInterface;

/**
 * Class AbstractApi
 * @package Webit\SoapApi
 */
abstract class AbstractApi
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
     * @var ExceptionFactoryInterface
     */
    private $exceptionFactory;

    public function __construct(
        \SoapClient $soapClient,
        InputNormalizerInterface $inputNormalizer,
        HydratorInterface $hydrator,
        ExceptionFactoryInterface $exceptionFactory = null
    ) {
        $this->soapClient = $soapClient;
        $this->inputNormalizer = $inputNormalizer;
        $this->hydrator = $hydrator;
        $this->exceptionFactory = $exceptionFactory;
    }

    /**
     * @param string $soapFunction
     * @param mixed $input
     * @throws \Exception
     */
    protected function doRequest($soapFunction, $input = array())
    {
        try {
            $input = $this->inputNormalizer->normalizeInput($soapFunction, $input);
            $result = $this->soapClient->__soapCall($soapFunction, $input);
            return $this->hydrator->hydrateResult($result, $soapFunction, $input);
        } catch (HydrationException $e) {
            throw $e;
        } catch (NormalizationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $this->exceptionFactory ? $this->exceptionFactory->createException($e, $soapFunction, $input) : $e;
        }
    }
}
