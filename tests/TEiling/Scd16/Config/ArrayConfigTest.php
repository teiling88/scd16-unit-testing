<?php

namespace TEiling\Scd16\Config;

use TEiling\Scd16\PluginTest;

class ArrayConfigTest extends PluginTest
{
    /** @var ArrayConfig */
    protected $arrayConfig;

    /** @var  string $imagePath */
    protected $imagePath;

    /** @var  string $csvPath */
    protected $csvPath;

    public function setUp()
    {
        parent::setUp();
        $this->imagePath = '/var/www/images/';
        $this->csvPath = '/var/www/csv/';
        $this->arrayConfig = new ArrayConfig($this->imagePath, $this->csvPath);
    }

    /**
     * @group unit-tests
     * @covers ArrayConfig::getImagePath()
     */
    public function testImagePath()
    {
        static::assertEquals($this->imagePath, $this->arrayConfig->getImagePath());
    }

    /**
     * @group unit-tests
     * @covers ArrayConfig::getCsvPath()
     */
    public function testCsvPath()
    {
        static::assertEquals($this->csvPath, $this->arrayConfig->getCsvPath());
    }

    /**
     * @group unit-tests
     * @covers ArrayConfig::getGroupName()
     */
    public function testDefaultGroupName()
    {
        static::assertEquals('Größe', $this->arrayConfig->getGroupName());
    }

    /**
     * @group unit-tests
     * @covers ArrayConfig::getDefaultTaxId()
     */
    public function testDefaultTaxId()
    {
        static::assertEquals(1, $this->arrayConfig->getDefaultTaxId());
    }
}
