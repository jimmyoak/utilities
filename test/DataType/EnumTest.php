<?php

namespace JimmyOak\Test\DataType;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    const A_NOT_VALID_VALUE = 'A NOT VALID VALUE';

    /** @test */
    public function shouldReturnType()
    {
        $value = TestableEnum::TESTABLE_VALUE1;
        $enum = new TestableEnum($value);

        $this->assertSame($value, $enum->type());
    }

    /** @test */
    public function shouldReturnStringifiedType()
    {
        $value = TestableEnum::TESTABLE_VALUE1;
        $enum = new TestableEnum($value);

        $this->assertSame((string) $value, (string) $enum);
    }

    /** @test */
    public function shouldGetConstantList()
    {
        $constants = TestableEnum::getConstList();

        $expected = [
            'TESTABLE_VALUE1' => 0,
            'TESTABLE_VALUE2' => 1,
        ];
        $this->assertSame($expected, $constants);
    }

    /** @test */
    public function shouldGetConstantsListForMultipleClasses()
    {
        $constants = TestableEnum::getConstList();
        $anotherConstants = AnotherTestableEnum::getConstList();

        $this->assertSame([
                'TESTABLE_VALUE1' => 0,
                'TESTABLE_VALUE2' => 1,
            ], $constants);
        $this->assertSame([
                'TESTABLE_VALUE3' => 0,
                'TESTABLE_VALUE4' => 1,
            ], $anotherConstants);
    }

    /** @test */
    public function shouldThrowExceptionOnNotAValidEnumValue()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        new TestableEnum(self::A_NOT_VALID_VALUE);
    }
}
