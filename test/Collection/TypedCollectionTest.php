<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\TypedCollection;
use JimmyOak\Test\Value\DateTimeChild;

class TypedCollectionTest extends CollectionTest
{
    protected $collectionObjectType = '\DateTime';
    /** @var TypedCollection */
    protected $collection;

    protected function setUp()
    {
        $this->collection = new TypedCollection($this->collectionObjectType);
    }

    /** @test */
    public function shouldThrowExceptionOnNonExistentOffset()
    {
        $this->setExpectedException('\JimmyOak\Exception\Collection\UndefinedOffsetException');
        $value = $this->collection[0];
        $this->assertNull($value);
    }

    /** @test */
    public function shouldThrowExceptionOnAddingAnotherTypeThanExpected()
    {
        $this->setExpectedException('\JimmyOak\Exception\Collection\NotValidObjectTypeException');
        $this->collection[] = new \stdClass();
    }

    /** @test */
    public function shouldNotThrowExceptionOnAddingSubClassOfExpectedType()
    {
        $nowDateTime = new DateTimeChild();
        $this->collection[] = $nowDateTime;
        $this->assertSame($nowDateTime, $this->collection[0]);
    }

    /** @test */
    public function shouldGetCollectionObjectType()
    {
        $this->assertSame($this->collectionObjectType, $this->collection->getObjectType());
    }
}
