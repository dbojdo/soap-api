<?php
/**
 * File: RawExecutor.php
 * Created at: 2014-11-25 18:29
 */

namespace Webit\SoapApi\Executor;

use Webit\SoapApi\Executor\Exception\ExecutorException;

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
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $headers;

    /**
     * @param \SoapClient $soapClient
     * @param array $options
     * @param array $headers
     */
    public function __construct(\SoapClient $soapClient, array $options = [], array $headers = [])
    {
        $this->soapClient = $soapClient;
        $this->options = $options;
        $this->headers = $headers;
    }

    /**
     * @inheritdoc
     */
    public function executeSoapFunction($soapFunction, $input = null, array $options = [], array $headers = [])
    {
        try {
            return $this->soapClient->__soapCall(
                $soapFunction,
                (array)$input,
                array_merge($this->options, $options),
                array_merge($this->headers, $headers)
            );
        } catch (\Exception $e) {
            throw new ExecutorException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
