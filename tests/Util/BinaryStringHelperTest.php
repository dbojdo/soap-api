<?php
/**
 * File: BinaryStringHelperTest.php
 * Created at: 2014-11-29 00:21
 */
 
namespace Webit\SoapApi\Tests\Util;

use Webit\SoapApi\Util\BinaryStringHelper;

/**
 * Class BinaryStringHelperTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class BinaryStringHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldEncodeBinaryStringToBase64()
    {
        $input = new \stdClass();
        $input->file = file_get_contents(__DIR__.'/../Resources/image.png');
        $input->string = file_get_contents(__DIR__.'/../Resources/example.txt');
        $input->recusively = clone($input);

        $expected = new \stdClass();
        $expected->file = base64_encode(file_get_contents(__DIR__.'/../Resources/image.png'));
        $expected->string = file_get_contents(__DIR__.'/../Resources/example.txt');
        $expected->recusively = clone($expected);

        $helper  = new BinaryStringHelper();
        $helper->encodeBinaryString($input);

        $this->assertEquals($expected, $input);
    }
}
