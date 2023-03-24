<?php
/**
 * AbstractTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 14, 2015, 16:31
 */

namespace Webit\SoapApi\Tests;

use JMS\Serializer\ArrayTransformerInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @return \Mockery\MockInterface|\SoapClient
     */
    protected function mockSoapClient()
    {
        return \Mockery::mock('\SoapClient');
    }

    /**
     * @return \Mockery\MockInterface|\Webit\SoapApi\Executor\SoapApiExecutor
     */
    protected function mockApiExecutor()
    {
        return \Mockery::mock('Webit\SoapApi\Executor\SoapApiExecutor');
    }

    /**
     * @return \Mockery\MockInterface|\Webit\SoapApi\Input\InputNormaliser
     */
    protected function mockInputNormaliser()
    {
        return \Mockery::mock('Webit\SoapApi\Input\InputNormaliser');
    }

    /**
     * @return \Mockery\MockInterface|\Webit\SoapApi\Hydrator\Hydrator
     */
    protected function mockHydrator()
    {
        return \Mockery::mock('\Webit\SoapApi\Hydrator\Hydrator');
    }

    /**
     * @return \Mockery\MockInterface|ArrayTransformerInterface
     */
    protected function mockJmsSerializer()
    {
       return \Mockery::mock(ArrayTransformerInterface::class);
    }

    /**
     * @return \Mockery\MockInterface|\Webit\SoapApi\Hydrator\Serializer\ResultTypeMap
     */
    protected function mockResultTypeMap()
    {
        return \Mockery::mock('Webit\SoapApi\Hydrator\Serializer\ResultTypeMap');
    }

    /**
     * @return \Mockery\MockInterface|\Webit\SoapApi\Input\Serializer\SerializationContextFactory
     */
    protected function mockSerializationContextFactory()
    {
        return \Mockery::mock('\Webit\SoapApi\Input\Serializer\SerializationContextFactory');
    }
    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    protected function randomInt($min = null, $max = PHP_INT_MAX)
    {
        $min = (int)($min === null ? -PHP_INT_MAX : $min);
        $max = (int)($max === null ? PHP_INT_MAX : $max);

        return mt_rand($min, $max);
    }

    /**
     * @param int $max
     * @return int
     */
    protected function randomPositiveInt($max = PHP_INT_MAX)
    {
        return $this->randomInt(1, $max);
    }

    /**
     * @param int $length
     * @return bool|string
     */
    protected function randomString($length = 32)
    {
        $string = '';
        do {
            $string .= md5(microtime().$this->randomInt());
        } while (strlen($string) < $length);

        return substr($string, 0, $length);
    }

    /**
     * @return string
     */
    protected function randomPropertyName()
    {
        do {
            $propertyName = $this->randomString();
        } while(!preg_match('/^\D/', $propertyName));

        return $propertyName;
    }

    /**
     * @return bool
     */
    protected function randomBoolean()
    {
        return (bool)$this->randomInt(0, 1);
    }

    /**
     * @param array $data
     * @return \stdClass
     */
    protected function stdClass(array $data = array())
    {
        $stdClass = new \stdClass();
        foreach ($data as $key => $value) {
            $stdClass->{$key} = $value;
        }

        return $stdClass;
    }

    protected function tearDown(): void
    {
        \Mockery::close();
    }
}
