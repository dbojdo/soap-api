<?php

namespace Webit\SoapApi\Tests\Hydrator;

use Webit\SoapApi\Hydrator\KeyExtractingHydrator;
use Webit\SoapApi\Tests\AbstractTest;

class KeyExtractingHydratorTest extends AbstractTest
{
    /**
     * @param $soapResponse
     * @param $expectedExtractedResponse
     * @test
     * @dataProvider responses
     */
    public function shouldExtractResponse($key, $soapResponse, $expectedExtractedResponse)
    {
        $hydrator = new KeyExtractingHydrator($key);

        $this->assertEquals(
            $expectedExtractedResponse,
            $hydrator->hydrateResult($soapResponse, $this->randomString())
        );
    }

    public function responses()
    {
        $examples = array(
            'stdClass not having "key"' => array(
                $this->randomString(),
                $soapResponse = $this->stdClass(),
                $soapResponse
            ),
            'stdClass having "key"' => array(
                $key = $this->randomString(),
                $soapResponse = $this->stdClass(array($key => $this->randomInt())),
                $soapResponse->{$key}
            ),
            'array' => array(
                $key = $this->randomString(),
                $soapResponse = array($key => array($this->randomString() => $this->randomInt())),
                $soapResponse[$key]
            )
        );

        return $examples;
    }
}
