<?php
/**
 * Ip.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@8x8.com>
 * Created on 12 17, 2015, 16:39
 * Copyright (C) 8x8
 */

namespace Webit\SoapApi\Features\Ip2Geo;

class Ip
{
    /**
     * @var string
     */
    private $ip;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function __toString()
    {
        return (string) $this->ip;
    }
}
