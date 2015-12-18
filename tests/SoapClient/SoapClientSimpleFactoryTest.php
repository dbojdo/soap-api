<?php
/**
 * SoapClientFactoryTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on Nov 25, 2014, 16:10
 */

namespace Webit\SoapApi\Tests\SoapClient;

use Webit\SoapApi\SoapClient\SoapClientSimpleFactory;
use Webit\SoapApi\Tests\AbstractTest;

/**
 * Class SoapClientFactoryTest
 * @package Webit\SoapApi\Tests\SoapClient
 */
class SoapClientFactoryTest extends AbstractTest
{
    /**
     * @test
     */
    public function shouldCreateSoapClientInstance()
    {
        $factory = new SoapClientSimpleFactory(__DIR__.'/../Resources/test-wsdl.xml', array());
        $soapClient = $factory->createSoapClient();

        $this->assertInstanceOf('\SoapClient', $soapClient);
    }
}
