<?php

namespace JimmyOak\Test\DataType;

use JimmyOak\DataType\SimpleValueObject;

class SimpleValueObjectTest extends \PHPUnit_Framework_TestCase
{
    const VALUE_OBJECT_VALUE = 12345;
    const ANOTHER_VALUE_OBJECT_VALUE = 123456;

    /**
     * @var SimpleValueObject|TestableValueObject
     */
    private $valueObject;

    protected function setUp()
    {
        $this->valueObject = new TestableValueObject(self::VALUE_OBJECT_VALUE);
    }

    /** @test */
    public function shouldBehaveLikeAValueObject()
    {
        $this->assertSame(self::VALUE_OBJECT_VALUE, $this->valueObject->value());

        $this->assertSame((string) self::VALUE_OBJECT_VALUE, (string) $this->valueObject);

        $anEqualValueObject = new TestableValueObject(self::VALUE_OBJECT_VALUE);
        $this->assertTrue($this->valueObject->equals($anEqualValueObject));

        $aDifferentValueObject = new TestableValueObject(self::ANOTHER_VALUE_OBJECT_VALUE);
        $this->assertFalse($this->valueObject->equals($aDifferentValueObject));

        $newInstance = $this->valueObject->modify(self::VALUE_OBJECT_VALUE);
        $this->assertNotSame($this->valueObject, $newInstance);
    }
}
