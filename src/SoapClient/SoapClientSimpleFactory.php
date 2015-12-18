<?php
/**
 * SoapClientFactory.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on Nov 25, 2014, 16:00
 */

namespace Webit\SoapApi\SoapClient;

/**
 * Class SoapClientFactory
 * @package Webit\SoapApi\SoapClient
 */
class SoapClientSimpleFactory implements SoapClientFactory
{
    /**
     * @var string
     */
    private $wsdl;

    /**
     * @var array
     */
    private $options = array();

    /**
     * SoapClientSimpleFactory constructor.
     * @param string $wsdl
     * @param array $options
     */
    public function __construct($wsdl, array $options = array())
    {
        $this->wsdl = $wsdl;
        $this->options = $options;
    }

    /**
     * @return \SoapClient
     */
    public function createSoapClient()
    {
        $builder = SoapClientBuilder::create();

        $builder->setWsdl($this->wsdl);
        $builder->setOptions($this->options);

        return $builder->build();
    }
}
