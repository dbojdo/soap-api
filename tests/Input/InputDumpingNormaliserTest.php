<?php

namespace Webit\SoapApi\Tests\Input;

use Webit\SoapApi\Input\InputDumpingNormaliser;
use Webit\SoapApi\Tests\AbstractTestCase;

class InputDumpingNormaliserTest extends AbstractTestCase
{
    /**
     * @var \Webit\SoapApi\Input\InputNormaliser|\Mockery\MockInterface
     */
    private $innerNormaliser;

    /**
     * @var \Webit\SoapApi\Util\Dumper\Dumper|\Mockery\MockInterface
     */
    private $dumper;

    /**
     * @var InputDumpingNormaliser
     */
    private $normaliser;

    protected function setUp(): void
    {
        $this->innerNormaliser = $this->mockInputNormaliser();
        $this->dumper = \Mockery::mock('Webit\SoapApi\Util\Dumper\Dumper');
        $this->normaliser = new InputDumpingNormaliser($this->innerNormaliser, $this->dumper);
    }

    /**
     * @test
     */
    public function shouldDumpNormalisedInput()
    {
        $this->innerNormaliser->shouldReceive('normaliseInput')->with(
            $soapFunction = $this->randomString(),
            $input = array($this->randomString() => $this->randomString())
        )
        ->andReturn($normalisedInput = $this->randomString())
        ->once();

        $this->dumper->shouldReceive('dump')->with(
            $normalisedInput,
            array('soapFunction' => $soapFunction)
        )->once();

        $this->assertSame($normalisedInput, $this->normaliser->normaliseInput($soapFunction, $input));
    }
}
