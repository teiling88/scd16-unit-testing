<?php

namespace TEiling\Scd16\Mapper;

use TEiling\Scd16\PluginIntegrationTest;
use TEiling\Scd16\Reader\CsvReader;

class ArticleMapperIntegrationTest extends PluginIntegrationTest
{
    /** @var ArticleMapper $articleMapper */
    private $articleMapper;

    /** @var CsvReader $csvReader */
    private $csvReader;

    /** @var array $csv */
    private $csv;


    public function setUp()
    {
        parent::setUp();
        $this->articleMapper = $this->container->get('teiling.scd16.mapper.article_mapper');
        $this->csvReader = $this->container->get('teiling.scd16.reader.csv_reader');
        $this->csv = $this->csvReader->readCsv($this->dir . '/fixtures/shopexport_short.csv');
    }
}
