<?php
/**
 * File: InputNormalizerSerializerBasedFactory.php
 * Created at: 2014-12-02 05:25
 */
 
namespace Webit\SoapApi\Input;

use JMS\Serializer\SerializerInterface;

/**
 * Class InputNormalizerSerializerBasedFactory
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class InputNormalizerSerializerBasedFactory
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $inputGroups
     * @return InputNormalizerSerializerBased
     */
    public function createNormalizer(array $inputGroups = array())
    {
        return new InputNormalizerSerializerBased($this->serializer, $inputGroups);
    }
}
 