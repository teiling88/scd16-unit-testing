<?php

namespace TEiling\Scd16\Importer;

use TEiling\Scd16\PluginIntegrationTest;

class ArticleImporterIntegrationTest extends PluginIntegrationTest
{
    /** @var ArticleImporter $importerArticle */
    private $importerArticle;

    public function setUp()
    {
        parent::setUp();
        $this->importerArticle = $this->container->get('teiling.scd16.importer.article_importer');
        $this->cleanUpArticleDatabase();
    }

    /**
     * @group integration-tests
     * @covers TEiling\Scd16\Importer\ArticleImporter::importArticles()
     * @throws \Shopware\Components\Api\Exception\NotFoundException
     * @throws \Shopware\Components\Api\Exception\ParameterMissingException
     * @throws \Shopware\Components\Api\Exception\ValidationException
     */
    public function testArticleImport()
    {
        static::assertEquals(
            [
                'updated' => 0,
                'created' => 4,
                'errors' => ''
            ],
            $this->importerArticle->importArticles($this->dir . '/fixtures/shopexport_short.csv')
        );

        static::assertEquals(
            [
                'updated' => 4,
                'created' => 0,
                'errors' => ''
            ],
            $this->importerArticle->importArticles($this->dir . '/fixtures/shopexport_short.csv')
        );
    }
}
