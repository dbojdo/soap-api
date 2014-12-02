<?php
/**
 * File: ResultTypeMapFactoryTest.php
 * Created at: 2014-12-02 05:40
 */
 
namespace Webit\SoapApi\Tests\ResultType;

use Webit\SoapApi\ResultType\ResultTypeMapFactory;

/**
 * Class ResultTypeMapFactoryTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class ResultTypeMapFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateResultTypeMap()
    {
        $factory = new ResultTypeMapFactory();
        $map = $factory->createResultTypeMap();
        $this->assertInstanceOf('Webit\SoapApi\ResultType\ResultTypeMap', $map);

        $map = $factory->createResultTypeMap('array');
        $this->assertInstanceOf('Webit\SoapApi\ResultType\ResultTypeMap', $map);

        $map = $factory->createResultTypeMap('array', array('function' => 'ArrayCollection<string>'));
        $this->assertInstanceOf('Webit\SoapApi\ResultType\ResultTypeMap', $map);
    }
}
