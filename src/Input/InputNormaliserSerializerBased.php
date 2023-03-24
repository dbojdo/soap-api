<?php
/**
 * File: InputNormaliserSerializerBased.php
 * Created at: 2014-11-26 20:37
 */

namespace Webit\SoapApi\Input;

use JMS\Serializer\ArrayTransformerInterface;
use Webit\SoapApi\Input\Exception\NormalisationException;
use Webit\SoapApi\Input\Serializer\SerializationContextFactory;

/**
 * Class InputNormaliserSerializerBased
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class InputNormaliserSerializerBased implements InputNormaliser
{
    /**
     * @var ArrayTransformerInterface
     */
    private $serializer;

    /**
     * @var SerializationContextFactory
     */
    private $contextFactory;

    /**
     * InputNormalizerSerializerBased constructor.
     * @param ArrayTransformerInterface $serializer
     * @param SerializationContextFactory $contextFactory
     */
    public function __construct(
        ArrayTransformerInterface $serializer,
        SerializationContextFactory $contextFactory
    ) {
        $this->serializer = $serializer;
        $this->contextFactory = $contextFactory;
    }

    /**
     * @param string $soapFunction
     * @param mixed $arguments
     * @throws NormalisationException
     * @return array
     */
    public function normaliseInput($soapFunction, $arguments)
    {
        try {
            $context = $this->contextFactory->createContext($soapFunction);

            return $this->serializer->toArray($arguments, $context);
        } catch (\Exception $e) {
            throw new NormalisationException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
