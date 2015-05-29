<?php

namespace JimmyOak\Test\Utility;

use JimmyOak\Utility\ArrayUtils;

class ArrayUtilsTest extends UtilsBaseTest
{
    /** @var ArrayUtils */
    protected $utils;

    private $expectedParsedXmlString;
    private $arrayToParseAsXml = [
        'details' => [
            'media' => [
                'image' => [
                    'anImage.png',
                    'anotherImage.png',
                ],
                'video' => 'aVideo.mp4',
                'audio' => [],
            ]
        ]
    ];
    private $expectedParsedXml;

    protected function setUp()
    {
        $this->expectedParsedXmlString = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<details>' .
            '<media>' .
            '<image>anImage.png</image>' .
            '<image>anotherImage.png</image>' .
            '<video>aVideo.mp4</video>' .
            '<audio/>' .
            '</media>' .
            '</details>';

        $this->expectedParsedXml = simplexml_load_string($this->expectedParsedXmlString);

        $this->utils = ArrayUtils::instance();
    }

    /** @test */
    public function array_flatten_makes_array_unidimensional()
    {
        $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $toFlat = [1, 2, 3, [4, 5, 6, [7, 8, 9]]];

        $result = $this->utils->flatten($toFlat);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function array_flatten_makes_array_unidimensional_preserving_keys()
    {
        $expected = [3, 'a' => 1, 'b' => 2, 'c' => 3];
        $toFlat = [1, 'a' => 1, 'b' => 1, 'c' => 1, [2, 'b' => 2, 'c' => 2, [3, 'c' => 3]]];

        $result = $this->utils->flatten($toFlat, ArrayUtils::PRESERVE_KEYS);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function array_flatten_makes_array_unidimensional_preserveing_associative_keys()
    {
        $expected = [1, 'a' => 1, 'b' => 2, 'c' => 3, 2, 3];
        $toFlat = [1, 'a' => 1, 'b' => 1, 'c' => 1, [2, 'b' => 2, 'c' => 2, [3, 'c' => 3]]];

        $result = $this->utils->flatten($toFlat, ArrayUtils::PRESERVE_ASSOCIATIVE_KEYS);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function array_converts_to_xml_string()
    {
        $result = $this->utils->toXmlString($this->arrayToParseAsXml);

        $this->assertSame($this->expectedParsedXmlString, $result);
    }

    /** @test */
    public function array_converts_to_simple_xml_element()
    {
        $result = $this->utils->toXml($this->arrayToParseAsXml);

        $this->assertEquals($this->expectedParsedXml, $result);
    }
}
