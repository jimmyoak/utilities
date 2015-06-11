<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\ArrayedObject;
use JimmyOak\DataType\ArrayedObjectFactory;
use JimmyOak\DataType\ArrayedObjectInstantiator;
use JimmyOak\Test\Value\AnotherDummyClass;
use JimmyOak\Test\Value\DummyClass;

class ArrayedObjectFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ArrayedObjectFactory */
    private $factory;

    protected function setUp()
    {
        $this->factory = new ArrayedObjectFactory();
    }

    /** @test */
    public function shouldCreateArrayedObjectFromObject()
    {
        $expectedData = $this->getExpectedData();
        $object = new DummyClass();

        $arrayedObject = $this->factory->create($object);

        $this->assertInstanceOf(ArrayedObject::class, $arrayedObject);
        $this->assertSame(DummyClass::class, $arrayedObject->getClass());
        $this->assertEquals($expectedData, $arrayedObject->getData());
    }

    private function getExpectedData()
    {
        $expectedData = [
            'aPrivateProperty' => 'A STRING',
            'aProtectedProperty' => 1234,
            'aPublicProperty' => 'ANOTHER STRING',
            'anObject' =>
                new ArrayedObject(AnotherDummyClass::class, [
                    'aValue' => 'Jimmy',
                    'anotherValue' => 'Kane',
                    'oneMoreValue' => 'Oak',
                ]),
            'anArrayOfObjects' =>
                array(
                    new ArrayedObject(AnotherDummyClass::class, [
                        'aValue' => 'Jimmy',
                        'anotherValue' => 'Kane',
                        'oneMoreValue' => 'Oak',
                    ]),
                    new ArrayedObject(AnotherDummyClass::class, [
                        'aValue' => 'Jimmy',
                        'anotherValue' => 'Kane',
                        'oneMoreValue' => 'Oak',
                    ]),
                ),
            'aParentProperty' => 5,
        ];
        return $expectedData;
    }
}
