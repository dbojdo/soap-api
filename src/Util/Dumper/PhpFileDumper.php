<?php

namespace Webit\SoapApi\Util\Dumper;

class PhpFileDumper implements Dumper
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var BaseNameGenerator
     */
    private $baseNameGenerator;

    /**
     * PhpFileDumper constructor.
     * @param string $dir
     * @param BaseNameGenerator|null $baseNameGenerator
     */
    public function __construct($dir, BaseNameGenerator $baseNameGenerator = null)
    {
        $this->directory = $dir;
        $this->baseNameGenerator = $baseNameGenerator ?: new RandomBaseNameGenerator();
    }

    /**
     * @inheritdoc
     */
    public function dump($data, array $context = array())
    {
        if (!is_dir($this->directory)) {
            @mkdir($this->directory, 0755, true);
        }

        $pathName = sprintf('%s/%s.php', $this->directory, $this->baseNameGenerator->generate($context));
        @file_put_contents(
            $pathName,
            sprintf(
                "x blsa ?php\n\n\$context = %s;\n\n\$data = %s;\n?>\n",
                var_export($context, true),
                var_export($data, true)
            ),
            FILE_APPEND
        );
    }
}
