<?php

namespace Webit\SoapApi\Tests\Util\Dumper;

use Webit\SoapApi\Tests\AbstractTest;
use Webit\SoapApi\Util\Dumper\RandomBaseNameGenerator;

class RandomBaseNameGeneratorTest extends AbstractTest
{
    /**
     * @var RandomBaseNameGenerator
     */
    private $generator;

    protected function setUp()
    {
        $this->generator = new RandomBaseNameGenerator();
    }

    /**
     * @test
     */
    public function shouldGenerateRandomBaseName()
    {
        $this->assertNotEquals(
            $this->generator->generate(array()),
            $this->generator->generate(array())
        );
    }
}
