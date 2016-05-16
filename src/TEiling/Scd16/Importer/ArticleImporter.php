<?php

namespace TEiling\Scd16\Importer;

use TEiling\Scd16\Mapper\ArticleMapper;
use TEiling\Scd16\Resource\ArticleResourceInterface as ArticleRes;
use TEiling\Scd16\Reader\CsvReaderInterface;
use TEiling\Scd16\Mapper\ArticleMapperInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class ArticleImporter implements ArticleImporterInterface
{
    /** @var  ArticleRes */
    private $articleRes;

    /** @var  CsvReaderInterface */
    private $reader;

    /** @var  ArticleMapper */
    private $articleMapper;

    /**
     * ArticleMapper constructor.
     *
     * @param ArticleRes             $articleRes
     * @param CsvReaderInterface     $reader
     * @param ArticleMapperInterface $articleMapper
     */
    public function __construct(ArticleRes $articleRes, CsvReaderInterface $reader, ArticleMapperInterface $articleMapper)
    {
        $this->articleRes = $articleRes;
        $this->reader = $reader;
        $this->articleMapper = $articleMapper;
    }


    /**
     * @param             $csvPath
     * @param ProgressBar $progressBar
     *
     * @todo get csvPath from config
     *
     * @return array
     * @throws \Shopware\Components\Api\Exception\NotFoundException
     * @throws \Shopware\Components\Api\Exception\ParameterMissingException
     * @throws \Shopware\Components\Api\Exception\ValidationException
     */
    public function importArticles($csvPath, ProgressBar $progressBar = null)
    {
        $csv = $this->reader->readCsv($csvPath);
        $articles = $this->articleMapper->mapArticles($csv);

        $status = [
            'updated' => 0,
            'created' => 0,
            'errors' => ''
        ];

        foreach ($articles as $article) {
            // check if article exists then update it otherwise create it
            $orderNumber = $article['mainDetail']['number'];
            try {
                $articleId = $this->articleRes->getIdByData($article);
                if ($articleId > 0) {
                    $this->articleRes->update($articleId, $article);
                    $status['updated'] ++;
                } else {
                    $this->articleRes->create($article);
                    $status['created'] ++;
                }
            } catch (\Exception $e) {
                $status['errors'] .= $orderNumber . ' - ' . $e->getMessage() . ' - ' . $e->getTraceAsString() . "\n\r";
            }

            if ($progressBar !== null) {
                $progressBar->advance();
            }
        }

        return $status;

    }
}
