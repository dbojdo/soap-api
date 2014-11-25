<?php
/**
 * ExceptionFactoryInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 15:56
 */

namespace Webit\SoapApi\Exception;

/**
 * Interface ExceptionFactoryInterface
 * @package Webit\SoapApi\Exception
 */
interface ExceptionFactoryInterface
{
    /**
     * Wraps exception to API's type
     *
     * @param \Exception $e
     * @param string $soapFunction
     * @param array $input
     * @return \Exception
     */
    public function createException(\Exception $e, $soapFunction, array $input);
}
