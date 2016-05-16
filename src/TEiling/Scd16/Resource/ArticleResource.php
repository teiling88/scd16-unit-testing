<?php

namespace TEiling\Scd16\Resource;

use Shopware\Components\Api\Resource\Article;

class ArticleResource implements ArticleResourceInterface
{
    /** @var Article $articleRes  */
    private $articleRes;

    /**
     * ArticleResource constructor.
     *
     * @param $articleRes
     */
    public function __construct(Article $articleRes)
    {
        $this->articleRes = $articleRes;
    }

    /**
     * @param $data
     *
     * @return int|boolean
     */
    public function getIdByData($data)
    {
        return $this->articleRes->getIdByData($data);
    }

    /**
     * @param       $articleId
     * @param array $article
     *
     * @return mixed
     * @throws \Shopware\Components\Api\Exception\ValidationException
     * @throws \Shopware\Components\Api\Exception\ParameterMissingException
     * @throws \Shopware\Components\Api\Exception\NotFoundException
     */
    public function update($articleId, array $article)
    {
        return $this->articleRes->update($articleId, $article);
    }

    /**
     * @param array $article
     *
     * @return mixed
     * @throws \Shopware\Components\Api\Exception\ValidationException
     * @throws \Shopware\Components\Api\Exception\CustomValidationException
     */
    public function create(array $article)
    {
        return $this->articleRes->create($article);
    }
}
