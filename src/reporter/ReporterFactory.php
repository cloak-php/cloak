<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reporter;

use PhpCollection\Map;
use \ReflectionClass;


/**
 * Class ReporterFactory
 * @package cloak\reporter
 */
class ReporterFactory
{

    /**
     * @var ReflectionClass
     */
    private $reflection;


    /**
     * @param ReflectionClass $reflection
     */
    public function __construct(ReflectionClass $reflection)
    {
        $this->reflection = $reflection;
    }

    /**
     * @param string $className
     * @return ReporterFactory
     */
    public static function fromClassName($className)
    {
        try {
            $reflection = new ReflectionClass($className);
        } catch (ReflectionException $exception) {
            throw new ReporterNotFoundException($exception);
        }

        return new self($reflection);
    }

    /**
     * @param array $arguments
     * @return \cloak\reporter\RepoterInterface
     */
    public function createWithArguments(array $arguments)
    {
        $assignValues = new Map($arguments);
        $assmebleArguments = $this->assmebleArguments($assignValues);
        return $this->reflection->newInstanceArgs($assmebleArguments);
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function assmebleArguments(Map $assignValues)
    {
        $assembleArguments = [];
        $constructorArguments = $this->getConstructorArguments();

        foreach ($constructorArguments as $orderNumber => $constructorArgument) {
            $argumentName = $constructorArgument->getName();
            $assignValue = $assignValues->get($argumentName);

            if ($assignValue->isEmpty()) {
                continue;
            }

            $assembleArguments[$orderNumber] = $assignValue->get();
        }

        return $assembleArguments;
    }

    /**
     * @return \ReflectionParameter[]
     */
    private function getConstructorArguments()
    {
        $constructor = $this->reflection->getConstructor();
        $parameters = $constructor->getParameters();

        return $parameters;
    }

}
