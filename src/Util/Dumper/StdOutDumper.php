<?php

namespace Webit\SoapApi\Util\Dumper;

class StdOutDumper implements Dumper
{
    /**
     * @inheritdoc
     */
    public function dump($data, array $context = array())
    {
        var_dump('Context: ', $context, 'Data:', $data);
    }
}
