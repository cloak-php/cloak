<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reflection;

use cloak\reflection\collection\ReflectionCollection;
use cloak\result\LineResultSelectable;
use cloak\value\LineRange;
use cloak\result\type\ClassResult;
use cloak\result\type\TraitResult;
use Zend\Code\Reflection\ClassReflection as ZendClassReflection;


/**
 * Class ClassReflection
 * @package cloak\reflection
 */
class ClassReflection implements ReflectionInterface
{

    /**
     * @var \Zend\Code\Reflection\ClassReflection
     */
    private $reflection;


    /**
     * @param string $className
     */
    public function __construct($className)
    {
        $this->reflection = new ZendClassReflection($className);
    }

    /**
     * @return string
     */
    public function getIdentityName()
    {
        $template = '%s\\%s';
        $assembleContent = sprintf(
            $template,
            $this->getNamespaceName(),
            $this->getName()
        );

        return $assembleContent;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->reflection->getName();
    }

    /**
     * @return string
     */
    public function getNamespaceName()
    {
        return $this->reflection->getNamespaceName();
    }

    /**
     * @return bool
     */
    public function isTrait()
    {
        return $this->reflection->isTrait();
    }

    /**
     * @return bool
     */
    public function isClass()
    {
        return $this->isTrait() === false;
    }

    /**
     * @return LineRange
     */
    public function getLineRange()
    {
        $startLine = $this->reflection->getStartLine();
        $endLine = $this->reflection->getEndLine();

        return new LineRange($startLine, $endLine);
    }

    /**
     * @return ReflectionCollection
     */
    public function getMethods()
    {
        $className = $this->reflection->getName();
        $selector = MethodSelector::fromClassName($className);

        $result = $selector->excludeNative()
            ->excludeInherited()
            ->excludeTraitMethods()
            ->toCollection();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function assembleBy(LineResultSelectable $selector)
    {

        if ($this->isClass()) {
            $result = new ClassResult($this, $selector);
        } else {
            $result = new TraitResult($this, $selector);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getIdentityName();
    }

}
