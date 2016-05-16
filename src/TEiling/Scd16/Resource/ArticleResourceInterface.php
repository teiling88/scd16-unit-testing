<?php

namespace TEiling\Scd16\Resource;

interface ArticleResourceInterface
{
    /**
     * @param $data
     *
     * @return int|boolean
     */
    public function getIdByData($data);

    /**
     * @param       $articleId
     * @param array $article
     *
     * @return mixed
     */
    public function update($articleId, array $article);

    /**
     * @param array $article
     *
     * @return mixed
     */
    public function create(array $article);
}
