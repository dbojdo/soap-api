<?php

namespace Webit\SoapApi\Util\Dumper;

interface Dumper
{
    /**
     * @param mixed $data
     * @param array $context
     */
    public function dump($data, array $context = array());
}