<?php
/**
 * File: InputNormalizerSerializedBasedTest.php
 * Created at: 2014-11-26 20:54
 */
 
namespace Webit\SoapApi\Tests\Input;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Webit\SoapApi\Input\InputNormalizerSerializedBased;

/**
 * Class InputNormalizerSerializedBasedTest
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class InputNormalizerSerializedBasedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldDelegateUseSerializerToProduceArray()
    {
        $input = new \stdClass();
        $expected = array();

        $serializer = $this->createSerializer();
        $serializer->expects($this->once())
                    ->method('serialize')
                    ->with(
                        $this->equalTo($input),
                        $this->equalTo('json'),
                        $this->callback(function ($context) {
                            $this->assertInstanceOf('JMS\Serializer\SerializationContext', $context);

                            return true;
                        })
                    )
                    ->willReturn('{}');

        $serializer->expects($this->once())
                    ->method('deserialize')
                    ->with($this->equalTo('{}'), $this->equalTo('array'), $this->equalTo('json'))
                    ->willReturn(array());

        $hydrator = new InputNormalizerSerializedBased($serializer);
        $hydrated = $hydrator->normalizeInput('test-function', $input);

        $this->assertEquals($expected, $hydrated);

    }

    /**
     * @test
     */
    public function shouldRespectGivenSerializationGroups()
    {
        $input = new \stdClass();
        $groups = array('input');

        $serializer = $this->createSerializer();
        $serializer->expects($this->once())
                    ->method('serialize')
                    ->with(
                        $this->equalTo($input),
                        $this->equalTo('json'),
                        $this->callback(function (SerializationContext $context) use ($groups) {
                            $attr = $context->attributes->get('groups');
                            $this->assertNotEmpty($attr);
                            $this->assertEquals($groups, $attr->get());

                            return true;
                        })
                    )
                    ->willReturn('{}');

        $serializer->expects($this->once())->method('deserialize')->willReturn(array());

        $hydrator = new InputNormalizerSerializedBased($serializer, $groups);
        $hydrator->normalizeInput('test-function', $input);
    }

    /**
     * @test
     * @expectedException \Webit\SoapApi\Hydrator\Exception\HydrationException
     */
    public function shouldThrowHydrationExceptionOnFail()
    {
        $input = new \stdClass();

        $serializer = $this->createSerializer();
        $serializer->expects($this->once())->method('serialize')->willThrowException($this->getMock('\Exception'));

        $hydrator = new InputNormalizerSerializedBased($serializer);
        $hydrator->normalizeInput('test-function', $input);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SerializerInterface
     */
    private function createSerializer()
    {
        $serializer = $this->getMock('JMS\Serializer\SerializerInterface');

        return $serializer;
    }
}
 