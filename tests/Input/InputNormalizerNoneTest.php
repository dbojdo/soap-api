<?php
/**
 * File: InputNormalizerNoneTest.php
 * Created at: 2014-11-25 19:54
 */
 
namespace Webit\SoapApi\Tests\Input;

use Webit\SoapApi\Input\InputNormalizerNone;

/**
 * Class InputNormalizerNoneTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class InputNormalizerNoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnSameResult()
    {
        /**
         * @test
         */
        $normalizer = new InputNormalizerNone();

        $input = new \stdClass();
        $input->x = 'y';

        $normalized = $normalizer->normalizeInput('test-function', $input);
        $this->assertSame($input, $normalized);
    }
}
 