<?php

namespace Webit\SoapApi\Tests\Util\Dumper;

use Webit\SoapApi\Tests\AbstractTestCase;
use Webit\SoapApi\Util\Dumper\StaticNameGenerator;

class StaticNameGeneratorTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function shouldGenerateStaticName()
    {
        $generator = new StaticNameGenerator($name = $this->randomString());

        $this->assertEquals(
            $name,
            $generator->generate(
                array(
                    $this->randomString() => $this->randomString()
                )
            )
        );
    }
}
