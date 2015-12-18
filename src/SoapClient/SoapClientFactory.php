<?php
/**
 * SoapClientFactoryInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on Nov 25, 2014, 15:59
 */

namespace Webit\SoapApi\SoapClient;

/**
 * Interface SoapClientFactoryInterface
 * @package Webit\SoapApi\SoapClient
 */
interface SoapClientFactory
{
    /**
     * @return \SoapClient
     */
    public function createSoapClient();
}
 