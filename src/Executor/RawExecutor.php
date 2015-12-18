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
     * @var string
     */
    private static $cacheKey = 'client';

    /**
     * @var SoapClientFactory
     */
    private $soapClientFactory;

    /**
     * @var ArrayCache
     */
    private $cache;

    /**
     * @param SoapClientFactory $soapClientFactory
     */
    public function __construct(SoapClientFactory $soapClientFactory)
    {
        $this->soapClientFactory = $soapClientFactory;
        $this->cache = new ArrayCache();
    }

    /**
     * @param string $soapFunction
     * @param mixed $input
     * @return mixed
     */
    public function executeSoapFunction($soapFunction, $input = null)
    {
        try {
            $soapClient = $this->getSoapClient();

            return $soapClient->__soapCall($soapFunction, array($input));
        } catch (\Exception $e) {
            throw new ExecutorException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return \SoapClient
     */
    private function getSoapClient()
    {
        if (! $this->cache->contains(self::$cacheKey)) {
            $soapClient = $this->soapClientFactory->createSoapClient();
            $this->cache->save(self::$cacheKey, $soapClient);

            return $soapClient;
        }

        return $this->cache->fetch(self::$cacheKey);
    }
}
