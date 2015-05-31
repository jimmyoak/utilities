<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\ArrayzedObject;
use JimmyOak\DataType\ArrayzedObjectInstantiator;
use JimmyOak\Test\Value\DummyClass;

class ArrayzedObjectInstantiatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var ArrayzedObjectInstantiator */
    private $instantiator;

    protected function setUp()
    {
        $this->instantiator = new ArrayzedObjectInstantiator();
    }

    /** @test */
    public function shouldFillObjectProperties()
    {
        $class = DummyClass::class;
        $data = [
            'aPrivateProperty' => 'PRIDUMMY',
            'aProtectedProperty' => 'PRODUMMY',
            'aPublicProperty' => 'PUBDUMMY',
            'aParentProperty' => 'PARDUMMY',
        ];

        $arrayzedObject = new ArrayzedObject($class, $data);
        /** @var DummyClass $instance */
        $instance = $this->instantiator->instantiate($arrayzedObject);

        $this->assertSame($data['aPrivateProperty'], $instance->getAPrivateProperty());
        $this->assertSame($data['aProtectedProperty'], $instance->getAProtectedProperty());
        $this->assertSame($data['aPublicProperty'], $instance->getAPublicProperty());
        $this->assertSame($data['aParentProperty'], $instance->getAParentProperty());
    }

    /** @test */
    public function shouldInstantiateRecursiveArrayzedObjects()
    {
        $class = DummyClass::class;
        $anArrayOfObjects = [
            new ArrayzedObject(DummyClass::class, [
                'aPrivateProperty' => 'DUMMYPRI',
                'aProtectedProperty' => 'DUMMYPRO',
                'aPublicProperty' => 'DUMMYPUB',
            ])
        ];
        $data = [
            'aPrivateProperty' => 'PRIDUMMY',
            'aProtectedProperty' => 'PRODUMMY',
            'aPublicProperty' => 'PUBDUMMY',
            'aParentProperty' => 'PARDUMMY',
            'anObject' => new ArrayzedObject($class, [
                'aPrivateProperty' => 'CHIPRIDUMMY'
            ]),
            'anArrayOfObjects' => $anArrayOfObjects
        ];

        $arrayzedObject = new ArrayzedObject($class, $data);
        /** @var DummyClass $instance */
        $instance = $this->instantiator->instantiate($arrayzedObject);

        $this->assertInstanceOf($class, $instance);
        $this->assertSame($data['aPrivateProperty'], $instance->getAPrivateProperty());
        $this->assertSame($data['aProtectedProperty'], $instance->getAProtectedProperty());
        $this->assertSame($data['aPublicProperty'], $instance->getAPublicProperty());
        $this->assertSame($data['aParentProperty'], $instance->getAParentProperty());

        /** @var DummyClass $anObject */
        $anObject = $instance->getAnObject();
        $this->assertInstanceOf($class, $anObject);
        $this->assertSame($data['anObject']['aPrivateProperty'], $anObject->getAPrivateProperty());

        /** @var DummyClass $anObjectOfTheArrayOfObjects */
        $anObjectOfTheArrayOfObjects = $instance->getAnArrayOfObjects()[0];
        $this->assertInstanceOf($class, $anObjectOfTheArrayOfObjects);
        $this->assertSame($anArrayOfObjects[0]['aPrivateProperty'],
            $anObjectOfTheArrayOfObjects->getAPrivateProperty());
        $this->assertSame($anArrayOfObjects[0]['aProtectedProperty'],
            $anObjectOfTheArrayOfObjects->getAProtectedProperty());
        $this->assertSame($anArrayOfObjects[0]['aPublicProperty'], $anObjectOfTheArrayOfObjects->getAPublicProperty());
    }
}
