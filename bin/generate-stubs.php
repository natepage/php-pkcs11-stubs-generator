<?php

declare(strict_types=1);

use NatePage\PhpPkcs11\StubsGenerator\ClassFinder;
use NatePage\PhpPkcs11\StubsGenerator\ClassGenerator;
use NatePage\PhpPkcs11\StubsGenerator\GlobalConstantsGenerator;

require_once __DIR__ . '/../vendor/autoload.php';

$distDir = __DIR__ . '/../dist/src';
$extensionDir = __DIR__ . '/../ext/php_pkcs11';
$classFinder = new ClassFinder();
$classGenerator = new ClassGenerator();
$constantsGenerator = new GlobalConstantsGenerator();

foreach ($classFinder->getClassesFromExtensionCode($extensionDir) as $class) {
    $classGenerator->generate($class, $distDir);
}

$constantsGenerator->generateConstantsDefinition($distDir);
