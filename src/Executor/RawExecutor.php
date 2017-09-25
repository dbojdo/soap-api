<?php
/**
 * File: RawExecutor.php
 * Created at: 2014-11-25 18:29
 */

namespace Webit\SoapApi\Executor;

use Doctrine\Common\Cache\ArrayCache;
use Webit\SoapApi\Executor\Exception\ExecutorException;
use Webit\SoapApi\SoapClient\SoapClientFactory;

/**
 * Class RawExecutor
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class RawExecutor implements SoapApiExecutor
{
    /**
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * @param \SoapClient $soapClient
     */
    public function __construct(\SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * @inheritdoc
     */
    public function executeSoapFunction($soapFunction, $input = null)
    {
        try {
            return $this->soapClient->__soapCall($soapFunction, $input);
        } catch (\Exception $e) {
            throw new ExecutorException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
