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

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param \stdClass $result
     * @param string $resultType
     * @return mixed
     */
    public function hydrateResult(\stdClass $result, $resultType)
    {
        if (! $resultType) {
            throw new HydrationException('Empty result type has been passed.');
        }

        $json = @json_encode($result);
        if (! $json) {
            throw new HydrationException('Could not serialized result into JSON.');
        }

        try {
            return $this->serializer->deserialize($json, $resultType, 'json');
        } catch (\Exception $e) {
            throw new HydrationException(
                sprintf('Error during result hydration to type "%s"', $resultType),
                null,
                $e
            );
        }
    }
}
