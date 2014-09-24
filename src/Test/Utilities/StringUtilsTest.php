<?php

namespace Test\Utilities;

use Utilities\StringUtils;

class StringUtilsTest extends UtilsBaseTest
{
    /** @var StringUtils */
    protected $utils;

    protected function setUp()
    {
        $this->utils = StringUtils::instance();
    }

    /** @test */
    public function string_begins_with()
    {
        $resultOk = $this->utils->beginsWith('Hello', 'He');
        $resultOk2 = $this->utils->beginsWith('Héllo', 'Hé');
        $resultKo = $this->utils->beginsWith('Hello', 'no');

        $this->assertTrue($resultOk);
        $this->assertTrue($resultOk2);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function string_begins_with_case_insensitive()
    {
        $resultOk = $this->utils->beginsWith('Hello', 'hel', StringUtils::CASE_INSENSITIVE);
        $resultKo = $this->utils->beginsWith('Hello', 'No', StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultOk);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function string_begins_with_accent_insensitive()
    {
        $resultAI = $this->utils->beginsWith('HéllÓ', 'Hel', StringUtils::ACCENT_INSENSITIVE);
        $resultAI2 = $this->utils->beginsWith('HéllÓ', 'Hél', StringUtils::ACCENT_INSENSITIVE);
        $resultCI_AI = $this->utils->beginsWith('HéllÓ', 'he', StringUtils::ACCENT_INSENSITIVE | StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultAI);
        $this->assertTrue($resultAI2);
        $this->assertTrue($resultCI_AI);
    }

    /** @test */
    public function string_remove_accents()
    {
        $result = $this->utils->removeAccents('HéllÓ');

        $this->assertSame('HellO', $result);
    }

    /** @test */
    public function string_ends_with()
    {
        $resultOk = $this->utils->endsWith('Hello', 'llo');
        $resultOk2 = $this->utils->endsWith('Hélló', 'lló');
        $resultKo = $this->utils->endsWith('Hello', 'no');

        $this->assertTrue($resultOk);
        $this->assertTrue($resultOk2);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function string_ends_with_case_insensitive()
    {
        $resultOk = $this->utils->endsWith('Hello', 'llo', StringUtils::CASE_INSENSITIVE);
        $resultKo = $this->utils->endsWith('Hello', 'No', StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultOk);
        $this->assertFalse($resultKo);
    }

    /** @test */
    public function string_ends_with_accent_insensitive()
    {
        $resultAI = $this->utils->endsWith('HéllÓ', 'llO', StringUtils::ACCENT_INSENSITIVE);
        $resultAI2 = $this->utils->endsWith('HéllÓ', 'llÓ', StringUtils::ACCENT_INSENSITIVE);
        $resultCI_AI = $this->utils->endsWith('HéllÓ', 'llo', StringUtils::ACCENT_INSENSITIVE | StringUtils::CASE_INSENSITIVE);

        $this->assertTrue($resultAI);
        $this->assertTrue($resultAI2);
        $this->assertTrue($resultCI_AI);
    }

    /** @test */
    public function removes_extra_spaces()
    {
        $result = $this->utils->removeExtraSpaces(' Hello,  my      name is   Jimmy  ');

        $expected = 'Hello, my name is Jimmy';
        $this->assertSame($expected, $result);
    }

    /** @test */
    public function string_is_url()
    {
        $isUrl = $this->utils->isUrl('http://www.youtube.com/watch?v=4DfG4G6h6HD');
        $isNotUrl = $this->utils->isUrl('asdfsdfsdfas');

        $this->assertTrue($isUrl);
        $this->assertFalse($isNotUrl);
    }

    /** @test */
    public function string_is_email()
    {
        $isEmail = $this->utils->isEmail('test.email@domain.com');
        $isNotEmail = $this->utils->isEmail('http://www.google.es');

        $this->assertTrue($isEmail);
        $this->assertFalse($isNotEmail);
    }
}
