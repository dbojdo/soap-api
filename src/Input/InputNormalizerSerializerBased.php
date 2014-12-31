<?php
/**
 * File: InputNormalizerSerializerBased.php
 * Created at: 2014-11-26 20:37
 */
 
namespace Webit\SoapApi\Input;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Webit\SoapApi\Hydrator\Exception\HydrationException;
use Webit\SoapApi\Input\Exception\NormalizationException;

/**
 * Class InputNormalizerSerializerBased
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class InputNormalizerSerializerBased implements InputNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    private $groups;

    /**
     * @var bool
     */
    private $serializeNull;

    public function __construct(SerializerInterface $serializer, $groups = array(), $serializeNull = false)
    {
        $this->serializer = $serializer;
        $this->groups = (array) $groups;
        $this->serializeNull = $serializeNull;
    }

    /**
     * @param string $soapFunction
     * @param mixed $arguments
     * @throws NormalizationException
     * @return array
     */
    public function normalizeInput($soapFunction, $arguments)
    {
        $context = $this->createContext();
        try {
            $json = $this->serializer->serialize($arguments, 'json', $context);
            $input = $this->serializer->deserialize($json, 'array', 'json');

            return $input;
        } catch (\Exception $e) {
            throw new HydrationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return SerializationContext
     */
    private function createContext()
    {
        $context = SerializationContext::create();
        $context->setSerializeNull($this->serializeNull);

        if ($this->groups) {
            $context->setGroups($this->groups);
        }

        return $context;
    }
}
 