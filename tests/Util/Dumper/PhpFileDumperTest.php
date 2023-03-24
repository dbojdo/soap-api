<?php

namespace Webit\SoapApi\Tests\Util\Dumper;

use Webit\SoapApi\Tests\AbstractTestCase;
use Webit\SoapApi\Util\Dumper\PhpFileDumper;
use Webit\SoapApi\Util\Dumper\StaticNameGenerator;

class PhpFileDumperTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function shouldDumpDataToPhpFile()
    {
        $directory = sys_get_temp_dir().'/'.$this->randomString(8);
        $baseNameGenerator = new StaticNameGenerator($this->randomString());

        $dumper = new PhpFileDumper($directory, $baseNameGenerator);

        $context = array(
            $this->randomString() => $this->randomPositiveInt(),
            $this->randomString() => $this->randomInt()
        );

        $data = array(
            $this->randomString() => $this->randomPositiveInt(),
            $this->randomString() => $this->randomInt()
        );

        $dumper->dump(
            $data,
            $context
        );

        $expectedFile = $directory.'/'.$baseNameGenerator->generate($context).'.php';

        $this->assertFileExists($expectedFile);
        exec('php -l '.$expectedFile, $output, $result);
        $this->assertEquals(0, $result);
    }
}
