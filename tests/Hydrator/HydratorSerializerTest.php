<?php
/**
 * HydratorSerializerTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:43
 */

namespace Webit\SoapApi\Tests\Hydrator {

    use Doctrine\Common\Collections\ArrayCollection;
    use JMS\Serializer\SerializerInterface;
    use Webit\SoapApi\Hydrator\HydratorSerializer;
    use Webit\SoapApi\Hydrator\Result\ResultMapInterface;

    /**
     * Class HydratorSerializerTest
     * @package Webit\SoapApi\Tests\Hydrator
     */
    class HydratorSerializerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Resource
         */
        private $resource;

        /**
         * @test
         */
        public function shouldReturnArrayCollectionByDefault()
        {
            $serializer = $this->createSerializer();
            $serializer->expects($this->once())->method('deserialize')
                ->with($this->isType('string'), $this->equalTo('ArrayCollection'), $this->equalTo('json'))
                ->willReturn(new ArrayCollection());

            $hydrator = new HydratorSerializer($serializer);
            $result = $hydrator->hydrateResult(new \stdClass(), 'test-function', array());

            $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $result);
        }

        /**
         * @test
         */
        public function shouldFindResultTypeInResultTypeMapAndHydrateToIt()
        {
            $map = $this->createResultMap();
            $map->expects($this->once())
                ->method('getResultType')
                ->with($this->equalTo('test-function'))
                ->willReturn('array');

            $serializer = $this->createSerializer();
            $serializer->expects($this->once())->method('deserialize')->willReturn(array());

            $hydrator = new HydratorSerializer($serializer, $map);
            $result = $hydrator->hydrateResult(new \stdClass(), 'test-function', array());

            $this->assertInternalType('array', $result);
        }

        /**
         * @test
         * @expectedException \Webit\SoapApi\Hydrator\Exception\HydrationException
         */
        public function shouldWrapDeserializationException()
        {
            $serializer = $this->createSerializer();
            $serializer->expects($this->once())->method('deserialize')->willThrowException(
                $this->getMock('\Exception')
            );

            $hydrator = new HydratorSerializer($serializer);
            $hydrator->hydrateResult(new \stdClass(), 'test-function', array());
        }

        /**
         * @test
         * @expectedException \Webit\SoapApi\Hydrator\Exception\HydrationException
         */
        public function shouldThrowExceptionOnJsonEncodingProblem()
        {
            $serializer = $this->createSerializer();

            $hydrator = new HydratorSerializer($serializer);
            $result = new \stdClass();

            $this->resource = fopen(__DIR__.'/../Resources/example.txt', 'r');
            $result->mytestresource = $this->resource;

            $hydrator->hydrateResult($result, 'test-function', array());
        }

        /**
         * @return \PHPUnit_Framework_MockObject_MockObject|SerializerInterface
         */
        private function createSerializer()
        {
            $serializer = $this->getMock('JMS\Serializer\SerializerInterface');

            return $serializer;
        }

        /**
         * @return \PHPUnit_Framework_MockObject_MockObject|ResultMapInterface
         */
        private function createResultMap()
        {
            $resultMap = $this->getMock('Webit\SoapApi\Hydrator\Result\ResultMapInterface');

            return $resultMap;
        }

        public function tearDown()
        {
            if (is_resource($this->resource)) {
                fclose($this->resource);
            }
        }
    }
}

/**
 * Workaround for json_encode (on some platforms doesn't return false)
 */
namespace Webit\SoapApi\Hydrator {
    function json_encode($data, $depth = 512)
    {
        if ($data->mytestresource) {
            return false;
        }

        return \json_encode($data, $depth);
    }
}
