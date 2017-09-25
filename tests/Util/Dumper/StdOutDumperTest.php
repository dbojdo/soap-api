<?php

namespace Webit\SoapApi\Tests\Util\Dumper;

use Webit\SoapApi\Tests\AbstractTest;
use Webit\SoapApi\Util\Dumper\StdOutDumper;

class StdOutDumperTest extends AbstractTest
{
    /**
     * @var StdOutDumper
     */
    private $dumper;

    protected function setUp()
    {
        $this->dumper = new StdOutDumper();
    }

    /**
     * @test
     */
    public function shouldDumpToStdOut()
    {
        $context = array($this->randomString() => $this->randomString());
        $data = $this->stdClass(array($this->randomPropertyName() => $this->randomString()));

        $expectedOutput = $this->expectedOutput($context, $data);

        ob_start();
        $this->dumper->dump($data, $context);
        $result = ob_get_clean();

        $this->assertEquals($expectedOutput, $result);
    }

    private function expectedOutput($context, $data)
    {
        ob_start();
        var_dump('Context: ', $context, 'Data:', $data);
        return ob_get_clean();
    }
}