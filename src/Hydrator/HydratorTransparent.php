<?php
/**
 * File: HydratorTransparent.php
 * Created at: 2014-11-26 20:42
 */
 
namespace Webit\SoapApi\Hydrator;

use Webit\SoapApi\Hydrator\Exception\HydrationException;

/**
 * Class HydratorTransparent
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class HydratorTransparent implements HydratorInterface
{
    /**
     * @param \stdClass $result
     * @param string $resultType
     * @return \stdClass
     */
    public function hydrateResult(\stdClass $result, $resultType)
    {
        if ($resultType) {
            throw new HydrationException(
                sprintf('Hydrator "Transparent" does\'t support result type "%s"', $resultType)
            );
        }

        return $result;
    }
}
