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
        public function shouldReturnResultWithGivenType()
        {
            $serializer = $this->createSerializer();
            $serializer->expects($this->once())->method('deserialize')->willReturn(array());

            $hydrator = new HydratorSerializer($serializer);
            $result = $hydrator->hydrateResult(new \stdClass(), 'array');

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
            $hydrator->hydrateResult(new \stdClass(), 'array');
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

            $hydrator->hydrateResult($result, 'array');
        }

        /**
         * @test
         */
        public function shouldReturnGivenResultIfResultTypeIsEmpty()
        {
            $serializer = $this->createSerializer();

            $result = new \stdClass();

            $hydrator = new HydratorSerializer($serializer);
            $hydrated = $hydrator->hydrateResult($result, null);

            $this->assertSame($result, $hydrated);
        }

        /**
         * @return \PHPUnit_Framework_MockObject_MockObject|SerializerInterface
         */
        private function createSerializer()
        {
            $serializer = $this->getMock('JMS\Serializer\SerializerInterface');

            return $serializer;
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
