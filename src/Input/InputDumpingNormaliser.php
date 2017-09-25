<?php

namespace Webit\SoapApi\Input;

use Webit\SoapApi\Util\Dumper\Dumper;

class InputDumpingNormaliser implements InputNormaliser
{
    /**
     * @var InputNormaliser
     */
    private $normaliser;

    /**
     * @var Dumper
     */
    private $dumper;

    /**
     * InputDumpingNormaliser constructor.
     * @param InputNormaliser $normaliser
     * @param Dumper $dumper
     */
    public function __construct(InputNormaliser $normaliser, Dumper $dumper)
    {
        $this->normaliser = $normaliser;
        $this->dumper = $dumper;
    }

    /**
     * @inheritdoc
     */
    public function normaliseInput($soapFunction, $arguments)
    {
        $this->dumper->dump(
            $normalised = $this->normaliser->normaliseInput($soapFunction, $arguments),
            array(
                'soapFunction' => $soapFunction
            )
        );

        return $normalised;
    }
}
