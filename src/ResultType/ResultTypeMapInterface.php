<?php
/**
 * ResultTypeMapInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:36
 */

namespace Webit\SoapApi\ResultType;

/**
 * Class ResultTypeMapInterface
 * @package Webit\SoapApi\Hydrator
 */
interface ResultTypeMapInterface
{
    /**
     * @param string $soapFunction
     * @return string
     */
    public function getResultType($soapFunction);

    /**
     * @param string $soapFunction
     * @param string $type
     */
    public function registerType($soapFunction, $type);
}
