<?php
/**
 * Country.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 16, 2015, 11:27
 */

namespace Webit\SoapApi\Features\GlobalWeather;

class Country
{
    /**
     * @var string
     */
    private $name;

    /**
     * Country constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}
