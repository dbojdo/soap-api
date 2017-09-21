<?php

namespace Webit\SoapApi\Tests\Input;

use Webit\SoapApi\Input\ArrayWrappingNormaliser;
use Webit\SoapApi\Input\InputNormaliser;
use Webit\SoapApi\Tests\AbstractTest;

class ArrayWrappingNormaliserTest extends AbstractTest
{
    /**
     * @var InputNormaliser|\Mockery\MockInterface
     */
    private $innerNormaliser;

    /**
     * @var ArrayWrappingNormaliser
     */
    private $normaliser;

    protected function setUp()
    {
        $this->innerNormaliser = \Mockery::mock('Webit\SoapApi\Input\InputNormaliser');
        $this->normaliser = new ArrayWrappingNormaliser($this->innerNormaliser);
    }

    /**
     * @test
     */
    public function shouldWrapInputWithArray()
    {
        $this->innerNormaliser
            ->shouldReceive('normaliseInput')
            ->with($soapFunction = 'any-function', $input = array('x' => 'y'))
            ->andReturn($normalisedInput = array('Z' => '2'));

        $this->assertEquals(
            array($normalisedInput),
            $this->normaliser->normaliseInput($soapFunction, $input)
        );
    }
}