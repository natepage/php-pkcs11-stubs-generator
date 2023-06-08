<?php

declare(strict_types=1);

namespace NatePage\PhpPkcs11\StubsGenerator;

use Nette\PhpGenerator\ClassLike;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Symfony\Component\Filesystem\Filesystem;

final class ClassGenerator
{
    private const METHOD_RETURN_TYPES = __DIR__ . '/../config/method-return-types.php';

    private array $methodReturnTypes;

    public function __construct(
        private readonly Filesystem $filesystem = new Filesystem(),
        private readonly Printer $printer = new Printer(),
    ) {
        if ($this->filesystem->exists(self::METHOD_RETURN_TYPES)) {
            $this->methodReturnTypes = require_once self::METHOD_RETURN_TYPES;
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function generate(string $className, string $dir, ?array $classStack = null): void
    {
        $reflectionClass = new \ReflectionClass($className);
        $filename = \sprintf('%s/%s.php', $dir, $reflectionClass->getShortName());

        if ($this->filesystem->exists($filename)) {
            return;
        }

        // Handle circular references
        $classStack = $classStack ?? [];
        if (\in_array($reflectionClass->getShortName(), $classStack, true)) {
            return;
        }
        $classStack[] = $reflectionClass->getShortName();

        $class = (new ClassType($reflectionClass->getShortName()))
            ->setAbstract($reflectionClass->isAbstract())
            ->setFinal($reflectionClass->isFinal());

        // Constants
        foreach ($reflectionClass->getConstants(\ReflectionClassConstant::IS_PUBLIC) as $name => $value) {
            $class->addConstant($name, $value);
        }

        // Methods
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            $method = $class
                ->addMethod($reflectionMethod->getName())
                ->setVisibility(ClassLike::VisibilityPublic)
                ->setReturnType($reflectionMethod->getReturnType()?->getName());

            foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                // If type is an object, generate it
                $type = $reflectionParameter->getType();
                if ($type !== null && $type->isBuiltin() === false) {
                    try {
                        new \ReflectionClass($type->getName());
                        $this->generate($type->getName(), $dir, $classStack);
                    } catch (\Throwable $throwable) {
                    }
                }

                $parameter = $method
                    ->addParameter($reflectionParameter->getName())
                    ->setNullable($reflectionParameter->allowsNull())
                    ->setType($type?->getName());

                if ($reflectionParameter->isDefaultValueAvailable()) {
                    $parameter->setDefaultValue($reflectionParameter->getDefaultValue());
                }
                if ($reflectionParameter->isDefaultValueAvailable() === false && $reflectionParameter->allowsNull()) {
                    $parameter->setDefaultValue(null);
                }
            }

            $methodReturnType = $this->methodReturnTypes[$reflectionClass->getShortName()][$reflectionMethod->getName()] ?? null;
            if ($methodReturnType !== null) {
                $method->setReturnType($methodReturnType);
            }
        }

        // Properties
        foreach ($reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $type = $reflectionProperty->getType();

            $class
                ->addProperty($reflectionProperty->getName())
                ->setNullable($type?->allowsNull())
                ->setType($type?->getName())
                ->setVisibility(ClassLike::VisibilityPublic);
        }

        $contents = \sprintf(
            "<?php\n%s%s",
            $this->printer->printNamespace(new PhpNamespace($reflectionClass->getNamespaceName())),
            $this->printer->printClass($class)
        );

        $this->filesystem->dumpFile($filename, $contents);
    }
}