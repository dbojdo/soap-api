<?php
/**
 * AbstractApi.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 15:55
 */

namespace Webit\SoapApi;

/**
 * Class AbstractApi
 * @package Webit\SoapApi
 */
abstract class AbstractApi
{
    /**
     * @var SoapApiExecutorInterface
     */
    private $executor;

    /**
     * @param SoapApiExecutorInterface $soapApiExecutor
     */
    public function __construct(SoapApiExecutorInterface $soapApiExecutor)
    {
        $this->executor = $soapApiExecutor;
    }

    /**
     * @param string $soapFunction
     * @param mixed $input
     * @param null $resultType
     * @return mixed
     */
    protected function doRequest($soapFunction, $input = array(), $resultType = null)
    {
        return $this->executor->executeSoapFunction($soapFunction, $input, $resultType);
    }
}
