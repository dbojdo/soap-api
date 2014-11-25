<?php
/**
 * ResultMapInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:36
 */

namespace Webit\SoapApi\Hydrator\Result;

/**
 * Class ResultMapInterface
 * @package Webit\SoapApi\Hydrator
 */
interface ResultMapInterface
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
