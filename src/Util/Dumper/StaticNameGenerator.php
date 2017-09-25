<?php

namespace Webit\SoapApi\Util\Dumper;

class StaticNameGenerator implements BaseNameGenerator
{
    /**
     * @var string
     */
    private $baseName;

    /**
     * StaticNameGenerator constructor.
     * @param string $baseName
     */
    public function __construct($baseName)
    {
        $this->baseName = $baseName;
    }

    /**
     * @inheritdoc
     */
    public function generate(array $context)
    {
        return $this->baseName;
    }
}