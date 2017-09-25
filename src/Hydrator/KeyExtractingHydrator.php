<?php

namespace Webit\SoapApi\Hydrator;

class KeyExtractingHydrator implements Hydrator
{
    /** @var string */
    private $key;

    /**
     * KeyExtractingHydrator constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @inheritdoc
     */
    public function hydrateResult($result, $soapFunction)
    {
        $tmpResult = $result;
        if ($tmpResult instanceof \stdClass) {
            $tmpResult = get_object_vars($result);
        }

        if (array_key_exists($this->key, $tmpResult)) {
            return $tmpResult[$this->key];
        }

        return $result;
    }
}
