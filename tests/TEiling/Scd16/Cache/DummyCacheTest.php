<?php

namespace TEiling\Scd16\Cache;

use TEiling\Scd16\PluginTest;

class DummyCacheTest extends PluginTest
{
    /** @var  DummyCache */
    private $dummyCache;

    public function __construct($name, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dummyCache = new DummyCache();
    }

    /**
     * @group unit-tests
     * @covers DummyCache::load()
     */
    public function testLoadMethod()
    {
        self::assertEquals(false, $this->dummyCache->load('ID'));
    }

    /**
     * @group unit-tests
     * @covers DummyCache::save()
     */
    public function testSaveMethod()
    {
        self::assertEquals(true, $this->dummyCache->save('data', 'ID'));
    }

    /**
     * @group unit-tests
     * @covers DummyCache::test()
     */
    public function testTestMethod()
    {
        self::assertEquals(false, $this->dummyCache->test('ID'));
    }
}
