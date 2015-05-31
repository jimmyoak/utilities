<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\ArrayzedObject;
use JimmyOak\DataType\ArrayzedObjectInstantiator;
use JimmyOak\DataType\ReflectionArrayzedObjectInstantiator;
use JimmyOak\Test\Collection\CollectionTest;
use JimmyOak\Test\Value\DummyClass;

class ArrayzedObjectTest extends CollectionTest
{
    /** @test */
    public function shouldGetClassNameAndData()
    {
        $class = DummyClass::class;
        $data = [
            'someRandomData'
        ];

        $arrayzedObject = new ArrayzedObject($class, $data);

        $this->assertSame($class, $arrayzedObject->getClass());
        $this->assertSame($data, $arrayzedObject->getData());
    }
}
