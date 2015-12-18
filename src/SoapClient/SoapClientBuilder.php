<?php
/**
 * SoapClientBuilder.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 14, 2015, 15:27
 */

namespace Webit\SoapApi\SoapClient;

class SoapClientBuilder
{
    /**
     * @var string
     */
    private $wsdl;

    /**
     * @var array
     */
    private $options;

    /**
     * @return SoapClientBuilder
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param string $wsdl
     */
    public function setWsdl($wsdl)
    {
        $this->wsdl = $wsdl;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * @return \SoapClient
     */
    public function build()
    {
        return new \SoapClient($this->wsdl, $this->options);
    }
}
