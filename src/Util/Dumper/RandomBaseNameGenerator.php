<?php

namespace Webit\SoapApi\Util\Dumper;

class RandomBaseNameGenerator implements BaseNameGenerator
{
    /**
     * @inheritdoc
     */
    public function generate(array $context)
    {
        return substr(md5(mt_rand(0, 100000000).microtime()), 8);
    }
}
