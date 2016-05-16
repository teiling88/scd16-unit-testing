<?php

namespace TEiling\Scd16\Importer;

use Symfony\Component\Console\Helper\ProgressBar;

interface ArticleImporterInterface
{
    public function importArticles($csvPath, ProgressBar $progressBar);
}
