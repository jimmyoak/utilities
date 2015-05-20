<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\UniquedCollection;

class UniquedCollectionTest extends CollectionTest
{
    protected function setUp()
    {
        $this->collection = new UniquedCollection($this->collectionObjectType);
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
