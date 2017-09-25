<?php

namespace Webit\SoapApi\Hydrator;

use Webit\SoapApi\Util\Dumper\Dumper;

class ResultDumpingHydrator implements Hydrator
{
    /**
     * @var Dumper
     */
    private $dumper;

    /**
     * ResultDumpingHydrator constructor.
     * @param Dumper $dumper
     */
    public function __construct(Dumper $dumper)
    {
        $this->dumper = $dumper;
    }

    /**
     * @param \stdClass|array $result
     * @param string $soapFunction
     * @return mixed
     */
    public function hydrateResult($result, $soapFunction)
    {
        $this->dumper->dump($result, array('soapFunction' => $soapFunction));

        return $result;
    }
}
