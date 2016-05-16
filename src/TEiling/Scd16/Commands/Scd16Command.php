<?php

namespace TEiling\Scd16\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Shopware_Plugins_Core_Scd16_Container as Container;

class Scd16Command extends ShopwareCommand
{
    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('scd16:import:articles')
            ->setDescription('Import all Articles')
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_NONE,
                'If set, more infos will be printed'
            );
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     * @throws \Symfony\Component\DependencyInjection\Exception\BadMethodCallException
     * @throws \Zend_Cache_Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('debug')) {
            error_reporting(E_ALL);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        }

        $progress = new ProgressBar($output);
        $progress->start();

        $container = new Container();
        $path = Shopware()->Plugins()->Core()->Scd16()->Path() . '/tests/fixtures/shopexport_short.csv';
        $articleImporter = $container->get('teiling.scd16.importer.article_importer');

        $status = $articleImporter->importArticles($path, $progress);
        $progress->finish();
        $output->write("\n");
        $output->writeln('updated: ' . $status['updated']);
        $output->writeln('created: ' . $status['created']);
        $output->writeln('errors: ' . $status['errors']);
        $output->write("\n");
    }
}
