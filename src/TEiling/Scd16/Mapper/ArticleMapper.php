<?php

namespace TEiling\Scd16\Mapper;

use TEiling\Scd16\Config\ConfigInterface;
use TEiling\Scd16\Utils\ArticleUtil;

class ArticleMapper implements ArticleMapperInterface
{
    private $groupName;

    /** @var ConfigInterface */
    private $config;


    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->groupName = $this->config->getGroupName();

    }

    /**
     * @param array $csv
     *
     * @return array
     */
    public function mapArticles($csv)
    {
        $articles = [];
        foreach ($csv as $key => $entry) {
            if (strpos($entry['Artikelnummer'], '_1') !== false) {
                continue;
            }
            $article = $this->getArticleArray($entry);
            if ($csv[$key + 1]['Artikelnummer'] === $entry['Artikelnummer'] . '_1') {
                $secondLine = $csv[$key + 1];
                $secondLine['Artikelnummer'] = str_replace('_1', '', $secondLine['Artikelnummer']);
                $articleExtended = $this->getArticleArray($secondLine);

                $article['variants'] = array_merge($article['variants'], $articleExtended['variants']);

                $groupKeys = array_keys($article['configuratorSet']['groups']);
                if (is_array($groupKeys)) {
                    foreach ($groupKeys as $groupKey) {
                        $article['configuratorSet']['groups'][$groupKey]['options'] = array_merge(
                            $article['configuratorSet']['groups'][$groupKey]['options'],
                            $articleExtended['configuratorSet']['groups'][$groupKey]['options']
                        );
                    }
                }
            }
            // if in the first row no variant has a stock but the second row
            if ($article['mainDetail']['number'] === false && !empty($articleExtended['mainDetail']['number'])) {
                $article['mainDetail']['number'] = $articleExtended['mainDetail']['number'];
            }

            // we need at least one default order number ;-)
            if ($article['mainDetail']['number'] === false) {
                $stockArray = ArticleUtil::getKeyValueArray($entry['Bestand']);
                $article['mainDetail']['number'] = ArticleUtil::convertOrderNumber(
                    $entry['Artikelnummer'] . '-' . key($stockArray)
                );
                foreach ($article['variants'] as &$value) {
                    if ($value['number'] === $article['mainDetail']['number']) {
                        $value['isMain'] = true;
                        break;
                    }
                }
            }

            // testing category
            $article['categories'][] = [
                'id' => 4
            ];


            $articles[] = $article;
        }

        return $articles;

    }

    /**
     * @todo fixing magic number
     *
     * @param $article
     *
     * @return array
     */
    private function getArticleArray($article)
    {
        $articleArray = [
            'name' => $article['Hersteller'] . ' ' . $article['Modell'],
            'taxId' => 1,
            'active' => 1,
            'description' => $article['Notiz'],
            'lastStock' => $article['Abverkauf'],
            'supplier' => $article['Hersteller'],
            'mainDetail' => [
                'active' => 1,
                'inStock' => 0,
                'number' => ArticleUtil::getMainOrderNumber($article['Artikelnummer'], $article['Bestand']),
                'prices' => [
                    [
                        'customerGroupKey' => 'EK',
                        'price' => ArticleUtil::convertPrice($article['Preis']),
                        'pseudoPrice' => ArticleUtil::convertPrice($article['VKS'])
                    ],
                ]
            ]
        ];

        $this->attachArticleVariants($articleArray, $article);

        return $articleArray;
    }

    /**
     * @param $articleArray
     * @param $article
     */
    private function attachArticleVariants(&$articleArray, $article)
    {
        $stock = ArticleUtil::getKeyValueArray($article['Bestand']);

        if (key($stock) === '-') {
            return;
        }

        $ean = ArticleUtil::getKeyValueArray($article['EAN']);

        $groupOptions = [];
        $variants = [];

        foreach ($stock as $size => $value) {
            $variantNumber = ArticleUtil::convertOrderNumber($article['Artikelnummer'] . '-' . $size);
            $variants[] =
                [
                    'isMain' => $variantNumber === $articleArray['mainDetail']['number'],
                    'number' => $variantNumber,
                    'ean' => $ean[$size],
                    'active' => $stock[$size] > 0,
                    'inStock' => $stock[$size],
                    'additionalText' => $size,
                    'configuratorOptions' => [
                        [
                            'group' => $this->groupName,
                            'option' => $size
                        ]
                    ],
                    'prices' => [
                        [
                            'price' => ArticleUtil::convertPrice($article['Preis']),
                            'pseudoPrice' => ArticleUtil::convertPrice($article['VKS'])
                        ],
                    ],
                ];

            // add configurator set
            $groupOptions[] = ['name' => $size];

        }
        // add configurator set
        $articleArray['configuratorSet'] = [
            'type' => 1,
            'groups' => [
                [
                    'name' => $this->groupName,
                    'options' => $groupOptions
                ]
            ]
        ];

        $articleArray['variants'] = $variants;
    }
}
