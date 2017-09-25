<?php

namespace Webit\SoapApi\Hydrator;

use Webit\SoapApi\Tests\AbstractTest;
use Webit\SoapApi\Util\Dumper\Dumper;

class ResultDumpingHydratorTest extends AbstractTest
{
    /**
     * @var Dumper|\Mockery\MockInterface
     */
    private $dumper;

    /**
     * @var ResultDumpingHydrator
     */
    private $hydrator;

    protected function setUp()
    {
        $this->dumper = \Mockery::mock('Webit\SoapApi\Util\Dumper\Dumper');
        $this->hydrator = new ResultDumpingHydrator($this->dumper);
    }

    /**
     * @test
     */
    public function shouldDumpAndReturnTheResult()
    {
        $this->dumper->shouldReceive('dump')->with(
            $result = $this->stdClass(array($this->randomPropertyName() => $this->randomString())),
            array('soapFunction' => $soapFunction = $this->randomString())
        );

        $this->assertSame($result, $this->hydrator->hydrateResult($result, $soapFunction));
    }
}
