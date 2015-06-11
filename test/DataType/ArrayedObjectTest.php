<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\ArrayedObject;
use JimmyOak\DataType\ArrayedObjectInstantiator;
use JimmyOak\DataType\ReflectionArrayedObjectInstantiator;
use JimmyOak\Test\Collection\CollectionTest;
use JimmyOak\Test\Value\DummyClass;

class ArrayedObjectTest extends CollectionTest
{
    /** @test */
    public function shouldGetClassNameAndData()
    {
        $class = DummyClass::class;
        $data = [
            'someRandomData'
        ];

        $arrayedObject = new ArrayedObject($class, $data);

        $this->assertSame($class, $arrayedObject->getClass());
        $this->assertSame($data, $arrayedObject->getData());
    }
}
