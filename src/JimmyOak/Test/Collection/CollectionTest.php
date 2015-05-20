<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\Collection;
use JimmyOak\Exception\Collection\NotValidObjectTypeException;
use JimmyOak\Exception\Collection\UndefinedOffsetException;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $collectionObjectType = \DateTimeInterface::class;
    /** @var Collection */
    protected $collection;

    protected function setUp()
    {
        $this->collection = new Collection($this->collectionObjectType);
    }

    /** @test */
    public function shouldBeArrayAccessible()
    {
        $nowDateTime = new \DateTime();
        $yesterdayDateTime = new \DateTime('-1 day');

        $this->collection[] = $nowDateTime;
        $this->collection[1] = $yesterdayDateTime;

        $this->assertSame($nowDateTime, $this->collection[0]);
        $this->assertSame($yesterdayDateTime, $this->collection[1]);
        $this->assertTrue(isset($this->collection[1]));
        $this->assertFalse(isset($this->collection[2]));

        unset($this->collection[0]);

        $this->assertFalse(isset($this->collection[0]));
    }

    /** @test */
    public function shouldThrowExceptionOnNonExistentOffset()
    {
        $this->setExpectedException(UndefinedOffsetException::class);
        $value = $this->collection[0];
        $this->assertNull($value);
    }

    /** @test */
    public function shouldNotBeIncrementable()
    {
        $nowDateTime = new \DateTime();
        $this->collection[0] = $nowDateTime;
        $this->collection[0]++;
        $this->assertSame($nowDateTime, $this->collection[0]);
    }

    /** @test */
    public function shouldThrowExceptionOnAddingAnotherTypeThanExpected()
    {
        $this->setExpectedException(NotValidObjectTypeException::class);
        $this->collection[] = new \stdClass();
    }

    /** @test */
    public function shouldNotThrowExceptionOnAddingSubClassOfExpectedType()
    {
        $nowDateTime = new \DateTimeImmutable();
        $this->collection[] = $nowDateTime;
        $this->assertSame($nowDateTime, $this->collection[0]);
    }

    /** @test */
    public function shouldGetCollectionObjectType()
    {
        $this->assertSame($this->collectionObjectType, $this->collection->getObjectType());
    }

    /** @test */
    public function shouldBeCountable()
    {
        $this->collection[] = new \DateTime();
        $this->collection[] = new \DateTime();

        $this->assertCount(2, $this->collection);
    }

    /** @test */
    public function shouldBeIterable()
    {
        $values = [
            new \DateTime('-1 day'),
            new \DateTime(),
            new \DateTime('+1 day')
        ];

        $this->collection[] = $values[0];
        $this->collection[] = $values[1];
        $this->collection[] = $values[2];

        foreach ($this->collection as $key => $value) {
            $this->assertSame($values[$key], $value);
        }
    }

    /** @test */
    public function shouldBeIterableDespiteAKeyGap()
    {
        $values = [
            0 => new \DateTime('-1 day'),
            2 => new \DateTime('+1 day')
        ];

        $this->collection[0] = $values[0];
        $this->collection[2] = $values[2];

        foreach ($this->collection as $key => $value) {
            $this->assertSame($values[$key], $value);
        }
    }
}
