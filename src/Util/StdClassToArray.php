<?php
/**
 * StdClassToArray.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 15, 2015, 11:32
 */

namespace Webit\SoapApi\Util;

class StdClassToArray
{
    /**
     * @param \stdClass $stdClass
     * @return array
     */
    public function toArray(\stdClass $stdClass)
    {
        $array = (array) $stdClass;
        foreach ($array as &$value) {
            if ($value instanceof \stdClass) {
                $value = $this->toArray($value);
            }
        }

        return $array;
    }
}
