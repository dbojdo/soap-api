<?php
/**
 * SoapClientFactoryTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:10
 */

namespace Webit\SoapApi\Tests\SoapClient;

use Webit\SoapApi\SoapClient\SoapClientFactory;

/**
 * Class SoapClientFactoryTest
 * @package Webit\SoapApi\Tests\SoapClient
 */
class SoapClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateSoapClientInstance()
    {
        $factory = new SoapClientFactory();
        $soapClient = $factory->createSoapClient(__DIR__.'/../Resources/test-wsdl.xml', array());

        $this->assertInstanceOf('\SoapClient', $soapClient);
    }
}
