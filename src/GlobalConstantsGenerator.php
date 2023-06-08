<?php

declare(strict_types=1);

namespace NatePage\PhpPkcs11\StubsGenerator;

use Symfony\Component\Filesystem\Filesystem;

final class GlobalConstantsGenerator
{
    private const DEFAULT_FILENAME = 'constants.php';

    public function __construct(private readonly Filesystem $filesystem = new Filesystem())
    {
    }

    public function generateConstantsDefinition(string $dir): void
    {
        $filename = \sprintf('%s/%s', $dir, self::DEFAULT_FILENAME);
        if ($this->filesystem->exists($filename)) {
            return;
        }

        $contents = "<?php\n\n";
        foreach (\get_defined_constants(true)['pkcs11'] ?? [] as $name => $value) {
            $contents .= \sprintf("\define('%s', %s);\n", $name, $value);
        }

        $this->filesystem->dumpFile($filename, $contents);
    }
}