<?php

namespace Webit\SoapApi\Tests\Util\Dumper;

use Webit\SoapApi\Tests\AbstractTestCase;
use Webit\SoapApi\Util\Dumper\VoidDumper;

class VoidDumperTest extends AbstractTestCase
{
    /**
     * @var VoidDumper
     */
    private $dumper;

    protected function setUp(): void
    {
        $this->dumper = new VoidDumper();
    }

    /**
     * @test
     */
    public function shouldDoNothing()
    {
        $this->dumper->dump($this->randomString(), array($this->randomString() => $this->randomString()));
        $this->assertTrue(true);
    }
}
