<?php

declare(strict_types=1);

namespace NatePage\PhpPkcs11\StubsGenerator;

final class StubsGenerator
{
    public function __construct(
        private readonly ClassFinder $classFinder = new ClassFinder(),
        private readonly ClassGenerator $classGenerator = new ClassGenerator(),
        private readonly GlobalConstantsGenerator $globalConstantsGenerator = new GlobalConstantsGenerator(),
        private readonly PreviousStubsCleaner $previousStubsCleaner = new PreviousStubsCleaner()
    ) {
    }

    /**
     * @throws \ReflectionException
     */
    public function generate(string $distDir, string $extensionDir): void
    {
        $this->previousStubsCleaner->cleanUp($distDir);

        foreach ($this->classFinder->getClassesFromExtensionCode($extensionDir) as $class) {
            $this->classGenerator->generate($class, $distDir);
        }

        $this->globalConstantsGenerator->generateConstantsDefinition($distDir);
    }
}