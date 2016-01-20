<?php

namespace JimmyOak\Test\Utility;

use JimmyOak\Utility\UtilsBase;

abstract class UtilsBaseTest extends \PHPUnit_Framework_TestCase
{
    /** @var UtilsBase */
    protected $utils;

    /** @test */
    public function utilsIsSingletonAndCannotBePubliclyConstructedNorCloned()
    {
        $reflectionClass = new \ReflectionClass($this->utils);
        $constructor = $reflectionClass->getConstructor();
        $singletonMethod = $reflectionClass->getMethod('instance');

        $anInstantiation = $singletonMethod->invoke(null);
        $anotherInstantiation = $singletonMethod->invoke(null);

        $this->assertFalse($constructor->isPublic());
        $this->assertSame($anInstantiation, $anotherInstantiation);
        $this->setExpectedException('\Exception');

        clone $this->utils;
    }
}
