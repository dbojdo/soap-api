<?php
/**
 * SoapClientFactoryInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 15:59
 */

namespace Webit\SoapApi\SoapClient;

/**
 * Interface SoapClientFactoryInterface
 * @package Webit\SoapApi\SoapClient
 */
interface SoapClientFactoryInterface
{
    /**
     * @param string $wsdl
     * @param array $options
     * @return \SoapClient
     */
    public function createSoapClient($wsdl, array $options = array());
}
 