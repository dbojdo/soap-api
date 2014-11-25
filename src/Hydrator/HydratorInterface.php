<?php
/**
 * HydratorInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 15:57
 */

namespace Webit\SoapApi\Hydrator;

/**
 * Class HydratorInterface
 * @package Webit\SoapApi\Hydrator
 */
interface HydratorInterface
{
    /**
     * @param \stdClass $result
     * @param string $resultType
     * @return mixed
     */
    public function hydrateResult(\stdClass $result, $resultType);
}
