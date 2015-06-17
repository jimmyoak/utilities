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
        $this->instantiator = ArrayedObjectInstantiator::instance();
    }

    /** @test */
    public function shouldBeSingleton()
    {
        $isConstructorCallable = is_callable([$this->instantiator, '__construct']);

        $this->assertFalse($isConstructorCallable);
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

        $arrayedObject = new ArrayedObject(\DateTime::class, $dateTimeData);

        $instance = $this->instantiator->instantiate($arrayedObject);

        $this->assertEquals($expected, $instance);
    }

    /** @test */
    public function shouldCreateAndFillDateIntervalInstance()
    {
        $dateIntervalData = [
            'y' => 0,
            'm' => 0,
            'd' => 0,
            'h' => 1,
            'i' => 25,
            's' => 0,
            'weekday' => 0,
            'weekday_behavior' => 0,
            'first_last_day_of' => 0,
            'invert' => 0,
            'days' => false,
            'special_type' => 0,
            'special_amount' => 0,
            'have_weekday_relative' => 0,
            'have_special_relative' => 0,
        ];

        $expected = new \DateInterval('PT1H25M');

        $arrayedObject = new ArrayedObject(\DateInterval::class, $dateIntervalData);

        $instance = $this->instantiator->instantiate($arrayedObject);

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

        $arrayedObject = new ArrayedObject($class, $data);
        /** @var DummyClass $instance */
        $instance = $this->instantiator->instantiate($arrayedObject);

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

        $arrayedObject = new ArrayedObject($class, $data);
        /** @var DummyClass $instance */
        $instance = $this->instantiator->instantiate($arrayedObject);

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
