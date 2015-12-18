<?php
/**
 * SoapApiExecutorBuilderTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel@bojdo.eu>
 * Created on 12 17, 2015, 15:04
 */

namespace Webit\SoapApi\Tests\Executor;

use Webit\SoapApi\Executor\SoapApiExecutorBuilder;
use Webit\SoapApi\Tests\AbstractTest;

class ExecutorBuilderTest extends AbstractTest
{
    /**
     * @var SoapApiExecutorBuilder
     */
    private $builder;

    protected function setUp()
    {
        $this->builder = SoapApiExecutorBuilder::create();
        $this->builder->setSoapClientFactory(
            $this->mockSoapClientFactory()
        );
    }

    /**
     * @test
     */
    public function shouldBuildRawExecutor()
    {
        $this->assertInstanceOf(
            'Webit\SoapApi\Executor\RawExecutor',
            $this->builder->build()
        );
    }

    /**
     * @test
     */
    public function shouldBuildInputNormalisingExecutor()
    {
        $this->builder->setInputNormaliser($this->mockInputNormaliser());

        $this->assertInstanceOf(
            'Webit\SoapApi\Executor\InputNormalisingExecutor',
            $this->builder->build()
        );
    }

    /**
     * @test
     */
    public function shouldBuildHydratingExecutor()
    {
        $this->builder->setHydrator($this->mockHydrator());

        $this->assertInstanceOf(
            'Webit\SoapApi\Executor\ResultHydratingExecutor',
            $this->builder->build()
        );
    }

    /**
     * @test
     * @expectedException \Webit\SoapApi\Executor\Exception\MissingSoapClientFactoryException
     */
    public function shouldRequireSoapClientFactory()
    {
        $builder = SoapApiExecutorBuilder::create();
        $builder->build();
    }
}
