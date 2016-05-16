<?php

namespace TEiling\Scd16\Mapper;

use TEiling\Scd16\Config\ArrayConfig;
use TEiling\Scd16\PluginTest;
use TEiling\Scd16\Reader\CsvReader;

class ArticleMapperUnitTest extends PluginTest
{
    /** @var ArticleMapper $articleMapper */
    private $articleMapper;

    /** @var CsvReader $csvReader */
    private $csvReader;

    /**
     * @inheritdoc
     */
    public function __construct($name, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $config = new ArrayConfig(
            $this->dir . '/fixtures/images',
            $this->dir . '/fixtures/shopexport_short.csv'
        );
        $this->articleMapper = new ArticleMapper($config);
        $this->csvReader = new CsvReader();
    }

    /**
     * @group unit-tests
     * @covers TEiling\Scd16\Mapper\ArticleMapper:mapArticles()
     */
    public function testArticleMapperBasicStructure()
    {
        $csv = $this->csvReader->readCsv($this->dir . '/fixtures/shopexport_short.csv');
        $mappedArticles = $this->articleMapper->mapArticles($csv);

        foreach ($mappedArticles as $article) {
            self::assertArrayHasKey('name', $article);
            self::assertArrayHasKey('taxId', $article);
            self::assertArrayHasKey('active', $article);
            self::assertArrayHasKey('description', $article);
            self::assertArrayHasKey('supplier', $article);
            self::assertArrayHasKey('mainDetail', $article);
            self::assertArrayHasKey('categories', $article);
            $mainDetail = $article['mainDetail'];
            self::assertArrayHasKey('active', $mainDetail);
            self::assertArrayHasKey('inStock', $mainDetail);
            self::assertArrayHasKey('number', $mainDetail);
            self::assertArrayHasKey('prices', $mainDetail);
        }
    }

    /**
     * @group unit-tests
     * @covers TEiling\Scd16\Mapper\ArticleMapper:mapArticles()
     */
    public function testArticleMapperArticlesWithTwoRows()
    {
        $csv = $csvData = $this->csvReader->readCsv($this->dir . '/fixtures/shopexport_article_with_two_rows.csv');
        $mappedArticles = $this->articleMapper->mapArticles($csv);

        // based on 4 csv-rows we should get 2 article array elements
        self::assertCount(2, $mappedArticles);

        foreach ($mappedArticles as $article) {
            self::assertCount(1, $article['mainDetail']['prices']);

            self::assertArrayHasKey('configuratorSet', $article);
            self::assertCount(1, $article['configuratorSet']['groups']);

            self::assertArrayHasKey('variants', $article);
        }

        // specials checks on first article
        $firstArticle = $mappedArticles[0];

        // check if all variants and properties are in the mapped array structure
        self::assertCount(16, $firstArticle['configuratorSet']['groups'][0]['options']);
        self::assertCount(16, $firstArticle['variants']);

        // check if the expected order number is the main order number
        self::assertEquals('220040420-8.5', $firstArticle['mainDetail']['number']);
        foreach ($firstArticle['variants'] as $variant) {
            if ($variant['isMain'] === true) {
                self::assertEquals('220040420-8.5', $variant['number']);
            }
        }
    }

    /**
     * @group unit-tests
     * @covers TEiling\Scd16\Mapper\ArticleMapper:mapArticles()
     */
    public function testArticleMapperArticlesWithSpecialCharsInOrderNumber()
    {
        $csv = $this->csvReader->readCsv(
            $this->dir . '/fixtures/shopexport_article_with_special_chars_in_order_number.csv'
        );

        $mappedArticles = $this->articleMapper->mapArticles($csv);

        // check if the char / is removed from the order number
        self::assertEquals('917900000-36-37', $mappedArticles[0]['mainDetail']['number']);
    }

    /**
     * @group unit-tests
     * @covers TEiling\Scd16\Mapper\ArticleMapper:mapArticles()
     */
    public function testArticleMapperArticlesWithoutVariants()
    {
        $csv = $this->csvReader->readCsv(
            $this->dir . '/fixtures/shopexport_article_without_variants.csv'
        );
        $mappedArticles = array_pop($this->articleMapper->mapArticles($csv));

        // check if the char / is removed from the order number
        self::assertArrayNotHasKey('variants', $mappedArticles);
        self::assertArrayNotHasKey('configuratorSet', $mappedArticles);
    }
}
