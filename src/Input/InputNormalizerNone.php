<?php
/**
 * File: InputNormalizerNone.php
 * Created at: 2014-11-25 18:52
 */

namespace Webit\SoapApi\Input;

/**
 * Class InputNormalizerNone
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class InputNormalizerNone implements InputNormalizerInterface
{
    /**
     * @param string $soapFunction
     * @param mixed $arguments
     * @return array
     */
    public function normalizeInput($soapFunction, $arguments)
    {
        return $arguments;
    }
}
