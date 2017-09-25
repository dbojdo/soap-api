<?php

namespace Webit\SoapApi\Tests\Util\Dumper;

use Webit\SoapApi\Tests\AbstractTest;
use Webit\SoapApi\Util\Dumper\VoidDumper;

class VoidDumperTest extends AbstractTest
{
    /**
     * @var VoidDumper
     */
    private $dumper;

    protected function setUp()
    {
        $this->dumper = new VoidDumper();
    }

    /**
     * @test
     */
    public function shouldDoNothing()
    {
        $this->dumper->dump($this->randomString(), array($this->randomString() => $this->randomString()));
    }
}
