<?php

namespace Webit\SoapApi\Util\Dumper;

interface BaseNameGenerator
{
    /**
     * @param array $context
     * @return string
     */
    public function generate(array $context);
}
