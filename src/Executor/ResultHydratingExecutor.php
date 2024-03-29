<?php
/**
 * ResultHydratingExecutor.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 14, 2015, 14:02
 */

namespace Webit\SoapApi\Executor;

use Webit\SoapApi\Executor\Exception\HydrationException;
use Webit\SoapApi\Hydrator\Hydrator;

class ResultHydratingExecutor implements SoapApiExecutor
{
    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var SoapApiExecutor
     */
    private $soapApiExecutor;

    /**
     * ResultHydratingExecutor constructor.
     * @param Hydrator $hydrator
     * @param SoapApiExecutor $soapApiExecutor
     */
    public function __construct(Hydrator $hydrator, SoapApiExecutor $soapApiExecutor)
    {
        $this->hydrator = $hydrator;
        $this->soapApiExecutor = $soapApiExecutor;
    }

    /**
     * @inheritdoc
     */
    public function executeSoapFunction($soapFunction, $input = null, array $options = [], array $headers = [])
    {
        $result = $this->soapApiExecutor->executeSoapFunction($soapFunction, $input, $options, $headers);

        try {
            return $this->hydrator->hydrateResult($result, $soapFunction);
        } catch (\Exception $e) {
            throw new HydrationException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
