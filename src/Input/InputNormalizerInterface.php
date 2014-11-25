<?php
/**
 * InputNormalizerInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 15:58
 */

namespace Webit\SoapApi\Input;

use Webit\SoapApi\Input\Exception\NormalizationException;

/**
 * Class InputNormalizerInterface
 * @package Webit\SoapApi\Input
 */
interface InputNormalizerInterface
{
    /**
     * @param string $soapFunction
     * @param mixed $arguments
     * @throws NormalizationException
     * @return array
     */
    public function normalizeInput($soapFunction, $arguments);
}
