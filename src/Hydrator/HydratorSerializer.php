<?php
/**
 * HydratorSerializer.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:19
 */

namespace Webit\SoapApi\Hydrator;

use JMS\Serializer\SerializerInterface;
use Webit\SoapApi\Hydrator\Exception\HydrationException;
use Webit\SoapApi\Hydrator\Result\ResultMapInterface;

/**
 * Class HydratorSerializer
 * @package Webit\SoapApi\Hydrator
 */
class HydratorSerializer implements HydratorInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ResultMapInterface
     */
    private $resultMap;

    public function __construct(SerializerInterface $serializer, ResultMapInterface $resultMap = null)
    {
        $this->serializer = $serializer;
        $this->resultMap = $resultMap;
    }

    /**
     * @param \stdClass $result
     * @param string $soapFunction
     * @param array $input
     * @return mixed
     */
    public function hydrateResult(\stdClass $result, $soapFunction, array $input)
    {
        $json = @json_encode($result);
        if (! $json) {
            throw new HydrationException('Could not serialized result into JSON.');
        }

        try {
            $resultType = $this->resultMap ? $this->resultMap->getResultType($soapFunction) : 'ArrayCollection';
            return $this->serializer->deserialize($json, $resultType, 'json');
        } catch (\Exception $e) {
            throw new HydrationException(
                sprintf('Error during result hydration for SOAP function "%s"', $soapFunction),
                null,
                $e
            );
        }
    }
}
