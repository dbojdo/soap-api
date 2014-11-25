<?php
/**
 * SoapClientFactory.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:00
 */

namespace Webit\SoapApi\SoapClient;

/**
 * Class SoapClientFactory
 * @package Webit\SoapApi\SoapClient
 */
class SoapClientFactory implements SoapClientFactoryInterface
{
    /**
     * @param string $wsdl
     * @param array $options
     * @return \SoapClient
     */
    public function createSoapClient($wsdl, array $options = array())
    {
        return new \SoapClient($wsdl, $options);
    }
}
