<?php
/**
 * File: InputNormaliserSerializedBasedTest.php
 * Created at: 2014-11-26 20:54
 */

namespace Webit\SoapApi\Tests\Input;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Webit\SoapApi\Input\Exception\NormalisationException;
use Webit\SoapApi\Input\InputNormaliserSerializerBased;
use Webit\SoapApi\Input\Serializer\SerializationContextFactory;
use Webit\SoapApi\Tests\AbstractTestCase;

/**
 * Class InputNormaliserSerializedBasedTest
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class InputNormaliserSerializerBasedTest extends AbstractTestCase
{
    /**
     * @var Serializer|\Mockery\MockInterface
     */
    private $serialiser;

    /**
     * @var SerializationContextFactory|\Mockery\MockInterface
     */
    private $contextFactory;

    /**
     * @var InputNormaliserSerializerBased
     */
    private $normaliser;

    protected function setUp(): void
    {
        $this->serialiser = $this->mockJmsSerializer();
        $this->contextFactory = $this->mockSerializationContextFactory();
        $this->normaliser = new InputNormaliserSerializerBased(
            $this->serialiser,
            $this->contextFactory
        );
    }

    /**
     * @test
     */
    public function shouldNormaliseInputWithSerialiser()
    {
        $input = ['input'];
        $soapFunction = 'func';
        $context = SerializationContext::create();

        $normalised = ['normalised'];

        $this->contextFactory->shouldReceive('createContext')->with($soapFunction)->andReturn($context)->once();
        $this->serialiser->shouldReceive('toArray')->with($input, $context)->andReturn($normalised)->once();

        $this->assertEquals(
            $normalised,
            $this->normaliser->normaliseInput($soapFunction, $input)
        );
    }

    /**
     * @test
     */
    public function shouldWrapNormalisationException()
    {
        $input = ['input'];
        $soapFunction = 'func';
        $context = SerializationContext::create();

        $this->contextFactory->shouldReceive('createContext')->with($soapFunction)->andReturn($context)->once();
        $this->serialiser->shouldReceive('toArray')->andThrow('\Exception')->once();
        $this->expectException(NormalisationException::class);
        $this->normaliser->normaliseInput($soapFunction, $input);
    }
}
