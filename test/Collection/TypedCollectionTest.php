<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\TypedCollection;
use JimmyOak\Exception\Collection\NotValidObjectTypeException;
use JimmyOak\Exception\Collection\UndefinedOffsetException;

class TypedCollectionTest extends CollectionTest
{
    protected $collectionObjectType = \DateTimeInterface::class;
    /** @var TypedCollection */
    protected $collection;

    protected function setUp()
    {
        $this->collection = new TypedCollection($this->collectionObjectType);
    }

    /** @test */
    public function shouldThrowExceptionOnNonExistentOffset()
    {
        $this->setExpectedException(UndefinedOffsetException::class);
        $value = $this->collection[0];
        $this->assertNull($value);
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
