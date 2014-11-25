<?php
/**
 * ResultTypeMap.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:37
 */

namespace Webit\SoapApi\ResultType;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ResultTypeMap
 * @package Webit\SoapApi\Hydrator
 */
class ResultTypeMap implements ResultTypeMapInterface
{
    /**
     * @var ArrayCollection
     */
    private $types;

    /**
     * @var ArrayCollection
     */
    private $fallbackType;

    public function __construct($fallbackType = 'ArrayCollection')
    {
        $this->fallbackType = $fallbackType;
        $this->types = new ArrayCollection();
    }

    /**
     * @param string $soapFunction
     * @return string
     */
    public function getResultType($soapFunction)
    {
        return $this->types->get($soapFunction) ?: $this->fallbackType;
    }

    /**
     * @param string $soapFunction
     * @param string $type
     */
    public function registerType($soapFunction, $type)
    {
        $this->types->set($soapFunction, $type);
    }
}
