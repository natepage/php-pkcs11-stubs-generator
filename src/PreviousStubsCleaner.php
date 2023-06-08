<?php

declare(strict_types=1);

namespace NatePage\PhpPkcs11\StubsGenerator;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final class PreviousStubsCleaner
{
    public function __construct(private readonly Filesystem $filesystem = new Filesystem())
    {
    }

    public function cleanUp(string $distDir): void
    {
        $finder = (new Finder())
            ->in($distDir)
            ->files()
            ->name('*.php');

        foreach ($finder as $file) {
            $this->filesystem->remove($file->getRealPath());
        }
    }
}