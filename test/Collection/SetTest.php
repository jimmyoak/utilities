<?php

namespace JimmyOak\Test\Collection;

use JimmyOak\Collection\Set;

class SetTest extends CollectionTest
{
    protected function setUp()
    {
        $this->collection = new Set();
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
