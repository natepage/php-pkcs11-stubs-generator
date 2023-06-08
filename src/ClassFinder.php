<?php

declare(strict_types=1);

namespace NatePage\PhpPkcs11\StubsGenerator;

use Symfony\Component\Finder\Finder;
use function Symfony\Component\String\u;

final class ClassFinder
{
    public function getClassesFromExtensionCode(string $extensionDir): iterable
    {
        $files = (new Finder())
            ->in($extensionDir)
            ->files()
            ->name('*.c');

        foreach ($files as $file) {
            if ($file->getFilename() !== 'pkcs11.c') {
                $className = u($file->getContents())->match('/zend_class_entry \*ce_Pkcs11_(.*);/')[1];

                yield \sprintf('\Pkcs11\%s', $className);
            }
        }
    }
}