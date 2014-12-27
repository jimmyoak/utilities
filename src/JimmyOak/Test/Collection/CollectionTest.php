<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\Collection;
use JimmyOak\Exception\Collection\NotValidObjectTypeException;
use JimmyOak\Exception\Collection\UndefinedOffsetException;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    private $collectionObjectType = \DateTimeInterface::class;
    /** @var Collection */
    private $collection;

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
}
