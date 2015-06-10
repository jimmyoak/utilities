<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\ArrayedObject;
use JimmyOak\DataType\ArrayedObjectFactory;
use JimmyOak\DataType\ArrayedObjectInstantiator;
use JimmyOak\Test\Value\DummyClass;

class ArrayedObjectInstantiatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var ArrayedObjectInstantiator */
    private $instantiator;

    protected function setUp()
    {
        $this->instantiator = new ArrayedObjectInstantiator();
    }

    /** @test */
    public function shouldCreateAndFillDateTimeInstance()
    {
        $dateTimeData = [
            'date' => '1992-10-07 21:05:00.000000',
            'timezone_type' => 3,
            'timezone' => 'Europe/Madrid',
        ];
        $expected = new \DateTime($dateTimeData['date'], new \DateTimeZone($dateTimeData['timezone']));

        $arrayzedObject = new ArrayedObject(\DateTime::class, $dateTimeData);

        $instance = $this->instantiator->instantiate($arrayzedObject);

        $this->assertEquals($expected, $instance);
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

        $arrayzedObject = new ArrayedObject($class, $data);
        /** @var DummyClass $instance */
        $instance = $this->instantiator->instantiate($arrayzedObject);

        $this->assertSame($data['aPrivateProperty'], $instance->getAPrivateProperty());
        $this->assertSame($data['aProtectedProperty'], $instance->getAProtectedProperty());
        $this->assertSame($data['aPublicProperty'], $instance->getAPublicProperty());
        $this->assertSame($data['aParentProperty'], $instance->getAParentProperty());
    }

    /** @test */
    public function shouldInstantiateRecursiveArrayedObjects()
    {
        $class = DummyClass::class;
        $anArrayOfObjects = [
            new ArrayedObject(DummyClass::class, [
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
            'anObject' => new ArrayedObject($class, [
                'aPrivateProperty' => 'CHIPRIDUMMY'
            ]),
            'anArrayOfObjects' => $anArrayOfObjects
        ];

        $arrayzedObject = new ArrayedObject($class, $data);
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
