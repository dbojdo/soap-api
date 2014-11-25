<?php
/**
 * ResultMapTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 17:17
 */

namespace Webit\SoapApi\Tests\ResultType;

use Webit\SoapApi\ResultType\ResultTypeMap;

/**
 * Class ResultMapTest
 * @package Webit\SoapApi\Tests\Hydrator\Result
 */
class ResultMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveDefaultFallbackType()
    {
        $map = new ResultTypeMap();
        $this->assertInternalType('string', $map->getResultType('some-function'));
    }

    /**
     * @test
     */
    public function shouldBeAbleToRegisterType()
    {
        $map = new ResultTypeMap();
        $map->registerType('some-function', 'array');

        $this->assertEquals('array', $map->getResultType('some-function'));
    }
}
