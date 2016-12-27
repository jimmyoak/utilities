<?php

namespace JimmyOak\Test\Event;

use JimmyOak\Event\SingleEventPublisher;

class SingleEventPublisherTest extends EventPublisherTest
{
    protected function createEventPublisher()
    {
        return SingleEventPublisher::instance();
    }

    /**
     * @test
     */
    public function shouldBeSingleton()
    {
        $publisher = SingleEventPublisher::instance();
        $samePublisher = SingleEventPublisher::instance();

        $this->assertSame($publisher, $samePublisher);
    }

    /**
     * @test
     */
    public function shouldNotShareParentInstanceOnExtensionButShareInheritedInstance()
    {
        $aSingleEventPublisher = ASingleEventPublisher::instance();
        $anotherSingleEventPublisher = AnotherSingleEventPublisher::instance();

        $this->assertNotSame($aSingleEventPublisher, $anotherSingleEventPublisher);
        $this->assertSame(ASingleEventPublisher::instance(), $aSingleEventPublisher);
        $this->assertSame(AnotherSingleEventPublisher::instance(), $anotherSingleEventPublisher);
    }
}
