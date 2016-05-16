<?php

namespace TEiling\Scd16\Utils;

use TEiling\Scd16\PluginTest;

class ArticleUtilTest extends PluginTest
{
    /**
     * @group unit-tests
     *
     * @covers ArticleUtil::convertPrice()
     */
    public static function testConvertPrice()
    {
        self::assertEquals('10.50', ArticleUtil::convertPrice('10,50'));
    }

    /**
     * @group unit-tests
     *
     * @covers ArticleUtil::convertOrderNumber()
     */
    public static function testConvertOderNumber()
    {
        self::assertEquals('.5', ArticleUtil::convertOrderNumber('½'));
        self::assertEquals('-', ArticleUtil::convertOrderNumber('/'));
    }
}
