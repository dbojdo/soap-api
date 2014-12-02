<?php
/**
 * File: ResultTypeMapFactory.php
 * Created at: 2014-12-02 05:38
 */
 
namespace Webit\SoapApi\ResultType;

/**
 * Class ResultTypeMapFactory
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class ResultTypeMapFactory
{
    /**
     * @param string $fallbackType
     * @param array $map
     * @return ResultTypeMap
     */
    public function createResultTypeMap($fallbackType = 'ArrayCollection', array $map = array())
    {
        $resultMap = new ResultTypeMap($fallbackType);
        foreach ($map as $function => $resultType) {
            $resultMap->registerType($function, $resultType);
        }

        return $resultMap;
    }
}
