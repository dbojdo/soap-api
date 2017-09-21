<?php

namespace Webit\SoapApi\Input;

class ArrayWrappingNormaliser implements InputNormaliser
{
    /**
     * @var InputNormaliser
     */
    private $innerNormaliser;

    /**
     * ArrayWrappingNormaliser constructor.
     * @param InputNormaliser $innerNormaliser
     */
    public function __construct(InputNormaliser $innerNormaliser)
    {
        $this->innerNormaliser = $innerNormaliser;
    }

    /**
     * @inheritdoc
     */
    public function normaliseInput($soapFunction, $arguments)
    {
        return array($this->innerNormaliser->normaliseInput($soapFunction, $arguments));
    }
}
