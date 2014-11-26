<?php
/**
 * File: HydratorTransparentTest.php
 * Created at: 2014-11-26 20:45
 */

namespace Webit\SoapApi\Tests\Hydrator;

use Webit\SoapApi\Hydrator\HydratorTransparent;

/**
 * Class HydratorTransparentTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class HydratorTransparentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnSameObject()
    {
        $result = new \stdClass();
        $result->xxx = 'zzz';

        $hydrator = new HydratorTransparent();
        $hydrated = $hydrator->hydrateResult($result, null);

        $this->assertSame($result, $hydrated);
    }

    /**
     * @test
     * @expectedException \Webit\SoapApi\Hydrator\Exception\HydrationException
     */
    public function shouldSupportNoResultType()
    {
        $result = new \stdClass();
        $result->xxx = 'zzz';

        $hydrator = new HydratorTransparent();
        $hydrator->hydrateResult($result, 'array');
    }
}
