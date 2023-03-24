<?php

namespace Webit\SoapApi\Tests\Util\Dumper;

use Webit\SoapApi\Tests\AbstractTestCase;
use Webit\SoapApi\Util\Dumper\RandomBaseNameGenerator;

class RandomBaseNameGeneratorTest extends AbstractTestCase
{
    /**
     * @var RandomBaseNameGenerator
     */
    private $generator;

    protected function setUp(): void
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
