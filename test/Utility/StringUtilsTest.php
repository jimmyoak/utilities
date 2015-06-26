<?php

namespace JimmyOak\Test\Utility;

use JimmyOak\Utility\StringUtils;

class StringUtilsTest extends UtilsBaseTest
{
    /** @var StringUtils */
    protected $utils;

    protected function setUp()
    {
        $this->utils = StringUtils::instance();
    }

    /** @test */
    public function stringBeginsWith()
    {
        $resultOk = $this->utils->beginsWith('Hello', 'He');
        $resultOk2 = $this->utils->beginsWith('Héllo', 'Hé');
        $resultKo = $this->utils->beginsWith('Hello', 'no');

        $this->assertTrue($resultOk);
        $this->assertTrue($resultOk2);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function stringBeginsWithCaseInsensitive()
    {
        $resultOk = $this->utils->beginsWith('Hello', 'hel', StringUtils::CASE_INSENSITIVE);
        $resultKo = $this->utils->beginsWith('Hello', 'No', StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultOk);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function stringBeginsWithAccentInsensitive()
    {
        $resultAI = $this->utils->beginsWith('HéllÓ', 'Hel', StringUtils::ACCENT_INSENSITIVE);
        $resultAI2 = $this->utils->beginsWith('HéllÓ', 'Hél', StringUtils::ACCENT_INSENSITIVE);
        $resultCI_AI = $this->utils->beginsWith('HéllÓ', 'he', StringUtils::ACCENT_INSENSITIVE | StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultAI);
        $this->assertTrue($resultAI2);
        $this->assertTrue($resultCI_AI);
    }

    /** @test */
    public function stringRemoveAccents()
    {
        $result = $this->utils->removeAccents('HéllÓ');

        $this->assertSame('HellO', $result);
    }

    /** @test */
    public function stringEndsWithNeedle()
    {
        $resultOk = $this->utils->endsWith('Hello', 'llo');
        $resultOk2 = $this->utils->endsWith('Hélló', 'lló');
        $resultKo = $this->utils->endsWith('Hello', 'no');

        $this->assertTrue($resultOk);
        $this->assertTrue($resultOk2);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function stringEndsWithCaseInsensitive()
    {
        $resultOk = $this->utils->endsWith('Hello', 'llo', StringUtils::CASE_INSENSITIVE);
        $resultKo = $this->utils->endsWith('Hello', 'No', StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultOk);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function stringEndsWithAccentInsensitive()
    {
        $resultAI = $this->utils->endsWith('HéllÓ', 'llO', StringUtils::ACCENT_INSENSITIVE);
        $resultAI2 = $this->utils->endsWith('HéllÓ', 'llÓ', StringUtils::ACCENT_INSENSITIVE);
        $resultCI_AI = $this->utils->endsWith('HéllÓ', 'llo', StringUtils::ACCENT_INSENSITIVE | StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultAI);
        $this->assertTrue($resultAI2);
        $this->assertTrue($resultCI_AI);
    }

    /** @test */
    public function removesExtraSpaces()
    {
        $result = $this->utils->removeExtraSpaces(' Hello,  my      name is   Jimmy  ');

        $expected = 'Hello, my name is Jimmy';
        $this->assertSame($expected, $result);
    }

    /** @test */
    public function stringIsUrl()
    {
        $isUrl = $this->utils->isUrl('http://www.youtube.com/watch?v=4DfG4G6h6HD');
        $isNotUrl = $this->utils->isUrl('asdfsdfsdfas');

        $this->assertTrue($isUrl);
        $this->assertFalse($isNotUrl);
    }

    /** @test */
    public function stringIsEmail()
    {
        $isEmail = $this->utils->isEmail('test.email@domain.com');
        $isNotEmail = $this->utils->isEmail('http://www.google.es');

        $this->assertTrue($isEmail);
        $this->assertFalse($isNotEmail);
    }
}
