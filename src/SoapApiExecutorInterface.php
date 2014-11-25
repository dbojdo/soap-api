<?php
/**
 * File: SoapApiExecutorInterface.php
 * Created at: 2014-11-25 18:28
 */
 
namespace Webit\SoapApi;

/**
 * Interface SoapApiExecutorInterface
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
interface SoapApiExecutorInterface
{
    /**
     * @param string $soapFunction
     * @param mixed $input
     * @param string $resultType
     * @return mixed
     */
    public function executeSoapFunction($soapFunction, $input = null, $resultType = null);
}
 