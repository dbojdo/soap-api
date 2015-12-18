<?php
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Webit\SoapApi\Executor\SoapApiExecutorBuilder;
use Webit\SoapApi\Features\Ip2Geo\Hydrator\ResolveIPHydrator;
use Webit\SoapApi\Features\Ip2Geo\Ip;
use Webit\SoapApi\Features\Ip2Geo\Normaliser\ResolveIPNormaliser;
use Webit\SoapApi\SoapClient\SoapClientSimpleFactory;

/**
 * IP2GeoContext.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 17, 2015, 16:12
 */
class IP2GeoContext implements Context, SnippetAcceptingContext
{
    /**
     * @var boolean
     */
    private $mockSoapClient;

    /**
     * @var \Webit\SoapApi\Features\Ip2Geo\Ip2GeoSimpleClient
     */
    private $client;

    /**
     * @var mixed
     */
    private $result;

    public function __construct($mockSoapClient = true)
    {
        $this->mockSoapClient = $mockSoapClient;
    }

    /**
     * @When I ask for geo location for IP :arg1
     */
    public function iAskForGeoLocationForIp($ip)
    {
        $this->result = $this->client->getGeoLocation(new Ip($ip));
    }

    /**
     * @Then the geo location should be returned
     */
    public function theGeoLocationShouldBeReturned()
    {
        PHPUnit_Framework_TestCase::assertNotNull($this->result);
    }

    /**
     * @Given Given :arg1 IP2Geo Client API
     */
    public function givenIpgeoClientApi($type)
    {
        $factoryMethod = sprintf('create%sClient', ucfirst($type));
        if (! method_exists($this, $factoryMethod)) {
            throw new \InvalidArgumentException(sprintf('Unknown Client type: "%s"', $type));
        }

        $this->client = call_user_func(array($this, $factoryMethod));
    }

    private function createSimpleClient()
    {
        $builder = SoapApiExecutorBuilder::create();
        $builder->setSoapClientFactory(
            $this->createSoapClientFactory()
        );

        return new \Webit\SoapApi\Features\Ip2Geo\Ip2GeoSimpleClient(
            $builder->build()
        );
    }

    private function createInputNormalisingClient()
    {
        $builder = SoapApiExecutorBuilder::create();
        $builder->setSoapClientFactory(
            $this->createSoapClientFactory()
        );

        $builder->setInputNormaliser(
            new \Webit\SoapApi\Input\FrontInputNormaliser(
                array(
                    'ResolveIP' => new ResolveIPNormaliser()
                )
            )
        );

        return new \Webit\SoapApi\Features\Ip2Geo\Ip2GeoInputNormalisingClient(
            $builder->build()
        );
    }

    private function createResultHydratingClient()
    {
        $builder = SoapApiExecutorBuilder::create();
        $builder->setSoapClientFactory(
            $this->createSoapClientFactory()
        );

        $builder->setInputNormaliser(
            new \Webit\SoapApi\Input\FrontInputNormaliser(
                array(
                    'ResolveIP' => new ResolveIPNormaliser()
                )
            )
        );

        $builder->setHydrator(
            new \Webit\SoapApi\Hydrator\FrontHydrator(
                array(
                    'ResolveIP' => new ResolveIPHydrator()
                )
            )
        );

        return new \Webit\SoapApi\Features\Ip2Geo\Ip2GeoResultHydratingClient(
            $builder->build()
        );
    }

    private function createSoapClientFactory()
    {
        return new SoapClientSimpleFactory(
            'http://ws.cdyne.com/ip2geo/ip2geo.asmx?WSDL'
        );
    }
}
