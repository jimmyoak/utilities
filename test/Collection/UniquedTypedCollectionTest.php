<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\UniquedTypedCollection;

class UniquedTypedCollectionTest extends TypedCollectionTest
{
    protected function setUp()
    {
        $this->collection = new UniquedTypedCollection($this->collectionObjectType);
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
