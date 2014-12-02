<?php
/**
 * File: InputNormalizerSerializerBasedFactoryTest.php
 * Created at: 2014-12-02 05:28
 */
 
namespace Webit\SoapApi\Tests\Input;

use JMS\Serializer\SerializerInterface;
use Webit\SoapApi\Input\InputNormalizerSerializerBasedFactory;

/**
 * Class InputNormalizerSerializerBasedFactoryTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class InputNormalizerSerializerBasedFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateSerializerBasedNormalizer()
    {
        $serializer = $this->createSerializer();
        $factory = new InputNormalizerSerializerBasedFactory($serializer);
        $normalizer = $factory->createNormalizer(array('input'));

        $this->assertInstanceOf('Webit\SoapApi\Input\InputNormalizerSerializerBased', $normalizer);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SerializerInterface
     */
    private function createSerializer()
    {
        return $this->getMock('JMS\Serializer\SerializerInterface');
    }
}
 