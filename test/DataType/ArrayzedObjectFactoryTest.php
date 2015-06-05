<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\ArrayzedObject;
use JimmyOak\DataType\ArrayzedObjectFactory;
use JimmyOak\DataType\ArrayzedObjectInstantiator;
use JimmyOak\Test\Value\AnotherDummyClass;
use JimmyOak\Test\Value\DummyClass;

class ArrayzedObjectFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ArrayzedObjectFactory */
    private $factory;

    protected function setUp()
    {
        $this->factory = new ArrayzedObjectFactory();
    }

    /** @test */
    public function shouldCreateArrayzedObjectFromObject()
    {
        $expectedData = $this->getExpectedData();
        $object = new DummyClass();

        $arrayzedObject = $this->factory->create($object);

        $this->assertInstanceOf(ArrayzedObject::class, $arrayzedObject);
        $this->assertSame(DummyClass::class, $arrayzedObject->getClass());
        $this->assertEquals($expectedData, $arrayzedObject->getData());
    }

    private function getExpectedData()
    {
        $expectedData = [
            'aPrivateProperty' => 'A STRING',
            'aProtectedProperty' => 1234,
            'aPublicProperty' => 'ANOTHER STRING',
            'anObject' =>
                new ArrayzedObject(AnotherDummyClass::class, [
                    'aValue' => 'Jimmy',
                    'anotherValue' => 'Kane',
                    'oneMoreValue' => 'Oak',
                ]),
            'anArrayOfObjects' =>
                array(
                    new ArrayzedObject(AnotherDummyClass::class, [
                        'aValue' => 'Jimmy',
                        'anotherValue' => 'Kane',
                        'oneMoreValue' => 'Oak',
                    ]),
                    new ArrayzedObject(AnotherDummyClass::class, [
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
