<?php
/**
 * SoapApiExecutorBuilder.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 15, 2015, 13:36
 */

namespace Webit\SoapApi\Executor;

use Webit\SoapApi\Executor\Exception\MissingSoapClientFactoryException;
use Webit\SoapApi\Hydrator\Hydrator;
use Webit\SoapApi\Input\InputNormaliser;
use Webit\SoapApi\SoapClient\SoapClientFactory;

class SoapApiExecutorBuilder
{
    /**
     * @var SoapClientFactory
     */
    private $soapClientFactory;

    /**
     * @var InputNormaliser
     */
    private $inputNormaliser;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @return SoapApiExecutorBuilder
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param SoapClientFactory $soapClientFactory
     */
    public function setSoapClientFactory($soapClientFactory)
    {
        $this->soapClientFactory = $soapClientFactory;
    }

    /**
     * @param InputNormaliser $inputNormaliser
     */
    public function setInputNormaliser($inputNormaliser)
    {
        $this->inputNormaliser = $inputNormaliser;
    }

    /**
     * @param Hydrator $hydrator
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @return SoapApiExecutor
     */
    public function build()
    {
        if (! $this->soapClientFactory) {
            throw new MissingSoapClientFactoryException('SoapClientFactory must be set.');
        }

        $executor = new RawExecutor($this->soapClientFactory);
        if ($this->inputNormaliser) {
            $executor = new InputNormalisingExecutor($this->inputNormaliser, $executor);
        }

        if ($this->hydrator) {
            $executor = new ResultHydratingExecutor($this->hydrator, $executor);
        }

        return $executor;
    }
}
