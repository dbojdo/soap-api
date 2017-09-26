<?php

namespace Webit\SoapApi\Tests\Hydrator\Serializer\Listener;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use Webit\SoapApi\Hydrator\Serializer\Listener\ArrayEnsuringListener;
use Webit\SoapApi\Tests\AbstractTest;

class ArrayEnsuringListenerTest extends AbstractTest
{
    /**
     * @test
     * @dataProvider arrayData
     */
    public function shouldEnsureArrayForGivenKey($key, $notNull, $data, $expectedData)
    {
        $listener = new ArrayEnsuringListener(
            $key,
            $notNull
        );

        $event = new PreDeserializeEvent(
            DeserializationContext::create(),
            $data,
            array()
        );

        $listener->ensureArray($event);

        $this->assertEquals(
            $expectedData,
            $event->getData()
        );
    }

    public function arrayData()
    {
        return array(
            'non empty array' => array(
                $key = $this->randomString(),
                false,
                $data = array(
                    $key => array(
                        $this->randomString() => $this->randomString(),
                        $this->randomString() => $this->randomString()
                    )
                ),
                array(
                    $key => array(
                        $data[$key]
                    )
                )
            ),
            'non empty array of arrays' => array(
                $key = $this->randomString(),
                false,
                $data = array(
                    $key => array(
                        array(
                            $this->randomString() => $this->randomString(),
                            $this->randomString() => $this->randomString()
                        )
                    )
                ),
                $data
            ),
            'key does not exist' => array(
                $key = $this->randomString(),
                false,
                $data = array(),
                $data
            ),
            'key does not exist - not null' => array(
                $key = $this->randomString(),
                true,
                $data = array(),
                array(
                    $key => array()
                )
            )
        );
    }

    /**
     * @test
     */
    public function shouldCreateAValidCallable()
    {
        $data =  array(
            $key = $this->randomString() => array(
                $this->randomString() => $this->randomString()
            )
        );

        $event = new PreDeserializeEvent(
            DeserializationContext::create(),
            $data,
            array()
        );

        $callable = ArrayEnsuringListener::createCallable($key, false);
        call_user_func($callable, $event);

        $this->assertEquals(
            array(
                $key => array(
                    $data[$key]
                )
            ),
            $event->getData()
        );
    }
}
