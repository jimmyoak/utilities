<?php

namespace JimmyOak\Test\DataType;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    const A_NOT_VALID_VALUE = 'A NOT VALID VALUE';

    /** @test */
    public function should_return_type()
    {
        $value = TestableEnum::TESTABLE_VALUE1;
        $enum = new TestableEnum($value);

        $this->assertSame($value, $enum->type());
    }

    /** @test */
    public function should_return_stringified_type()
    {
        $value = TestableEnum::TESTABLE_VALUE1;
        $enum = new TestableEnum($value);

        $this->assertSame((string) $value, (string) $enum);
    }

    /** @test */
    public function should_throw_exception_on_not_a_valid_enum_value()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        new TestableEnum(self::A_NOT_VALID_VALUE);
    }
}
