<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\TypedSet;

class TypedSetTest extends TypedCollectionTest
{
    protected function setUp()
    {
        $this->collection = new TypedSet($this->collectionObjectType);
    }

    /** @test */
    public function shouldNotPushDuplicatedValue()
    {
        $instance = new \DateTime();

        $this->collection[] = $instance;
        $this->collection[] = $instance;

        $this->assertCount(1, $this->collection);
    }
}
