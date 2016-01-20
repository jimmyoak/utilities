<?php

namespace JimmyOak\Test\Utility;

use JimmyOak\Test\Value\DummyClass;
use JimmyOak\Utility\ObjectUtils;

class ObjectUtilsTest extends UtilsBaseTest
{
    /** @var ObjectUtils */
    protected $utils;

    private $expectedParsedXml;
    private $expectedParsedXmlString;
    private $objectToParse;

    protected function setUp()
    {
        $this->prepareObjectToParse();

        $this->expectedParsedXmlString = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<details>' .
            '<media>' .
            '<image>anImage.png</image>' .
            '<image>anotherImage.png</image>' .
            '<video>aVideo.mp4</video>' .
            '<audio/>' .
            '</media>' .
            '<resource>'.
            (string) $this->objectToParse->details->resource .
            '</resource>'.
            '</details>';

        $this->expectedParsedXml = simplexml_load_string($this->expectedParsedXmlString);

        $this->utils = ObjectUtils::instance();
    }

    /** @test */
    public function transformsObjectIntoArray()
    {
        $expected = array(
            'details' => array(
                'media' => array(
                    'image' => array(
                        'anImage.png',
                        'anotherImage.png',
                    ),
                    'video' => 'aVideo.mp4',
                    'audio' => array(),
                ),
                'resource' => (string) $this->objectToParse->details->resource,
            ),
        );

        $result = $this->utils->toArray($this->objectToParse);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function transformsObjectToXmlString()
    {
        $result = $this->utils->toXmlString($this->objectToParse);

        $this->assertSame($this->expectedParsedXmlString, $result);
    }

    /** @test */
    public function transformsObjectToXml()
    {
        $result = $this->utils->toXml($this->objectToParse);

        $this->assertEquals($this->expectedParsedXml, $result);
    }

    /** @test */
    public function transformsObjectToArrayDeeply()
    {
        $object = new DummyClass();
        $expected = array(
            'aPrivateProperty' => 'A STRING',
            'aProtectedProperty' => 1234,
            'aPublicProperty' => 'ANOTHER STRING',
            'anObject' => array(
                'aValue' => 'Jimmy',
                'anotherValue' => 'Kane',
                'oneMoreValue' => 'Oak',
            ),
            'anArrayOfObjects' => array(
                array(
                    'aValue' => 'Jimmy',
                    'anotherValue' => 'Kane',
                    'oneMoreValue' => 'Oak',
                ),
                array(
                    'aValue' => 'Jimmy',
                    'anotherValue' => 'Kane',
                    'oneMoreValue' => 'Oak',
                )
            ),
            'aResource' => (string) $object->aResource,
            'aParentProperty' => 5,
        );

        $objectAsArray = $this->utils->toArray($object, true);

        $this->assertSame($expected, $objectAsArray);
    }

    private function prepareObjectToParse()
    {
        $details = new \stdClass();

        $media = new \stdClass();
        $media->image = array('anImage.png', 'anotherImage.png');
        $media->video = 'aVideo.mp4';
        $media->audio = array();

        $details->media = $media;
        $details->resource = tmpfile();

        $this->objectToParse = new \stdClass();
        $this->objectToParse->details = $details;
    }
}
