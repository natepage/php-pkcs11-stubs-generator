<?php

declare(strict_types=1);

use NatePage\PhpPkcs11\StubsGenerator\StubsGenerator;

require_once __DIR__ . '/../vendor/autoload.php';

$distDir = __DIR__ . '/../../repos/php-pkcs11-ide-helper';
$extensionDir = __DIR__ . '/../../repos/php-pkcs11';

(new StubsGenerator())->generate($distDir, $extensionDir);
