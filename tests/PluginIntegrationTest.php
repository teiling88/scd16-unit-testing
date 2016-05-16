<?php

namespace TEiling\Scd16;

use Shopware\Components\Test\Plugin\TestCase;
use Shopware_Plugins_Core_Scd16_Bootstrap;
use Shopware_Plugins_Core_Scd16_Container as Container;
use TEiling\Scd16\Cache\DummyCache;

require('../../../../../../tests/Shopware/TestHelper.php');


class PluginIntegrationTest extends TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    protected $container;

    protected $dir;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        require_once(__DIR__ . '/../vendor/autoload.php');
        $this->dir = __DIR__;
        $cacheDummy = new DummyCache();
        $this->container = new Container(null, null, $cacheDummy);
    }

    public function cleanUpArticleDatabase()
    {
        $sql = 'SET foreign_key_checks = 0;
                TRUNCATE s_article_configurator_dependencies;
                TRUNCATE s_article_configurator_groups;
                TRUNCATE s_article_configurator_option_relations;
                TRUNCATE s_article_configurator_options;
                TRUNCATE s_article_configurator_set_group_relations;
                TRUNCATE s_article_configurator_set_option_relations;
                TRUNCATE s_article_configurator_sets;
                TRUNCATE s_article_configurator_template_prices;
                TRUNCATE s_article_configurator_template_prices_attributes;
                TRUNCATE s_article_configurator_templates;
                TRUNCATE s_article_configurator_templates_attributes;
                TRUNCATE s_article_img_mapping_rules;
                TRUNCATE s_article_img_mappings;
                TRUNCATE s_articles;
                TRUNCATE s_articles_also_bought_ro;
                TRUNCATE s_articles_attributes;
                TRUNCATE s_articles_avoid_customergroups;
                TRUNCATE s_articles_categories;
                TRUNCATE s_articles_categories_ro;
                TRUNCATE s_articles_details;
                TRUNCATE s_articles_downloads;
                TRUNCATE s_articles_downloads_attributes;
                TRUNCATE s_articles_esd;
                TRUNCATE s_articles_esd_attributes;
                TRUNCATE s_articles_esd_serials;
                TRUNCATE s_articles_img;
                TRUNCATE s_articles_img_attributes;
                TRUNCATE s_articles_information;
                TRUNCATE s_articles_information_attributes;
                TRUNCATE s_articles_notification;
                TRUNCATE s_articles_prices;
                TRUNCATE s_articles_prices_attributes;
                TRUNCATE s_articles_relationships;
                TRUNCATE s_articles_similar;
                TRUNCATE s_articles_similar_shown_ro;
                TRUNCATE s_articles_supplier;
                TRUNCATE s_articles_supplier_attributes;
                TRUNCATE s_articles_top_seller_ro;
                TRUNCATE s_articles_translations;
                TRUNCATE s_articles_vote;
                TRUNCATE s_filter_articles;
                SET foreign_key_checks = 1;';
        /** @var \Enlight_Components_Db_Adapter_Pdo_Mysql $db */
        $db = $this->container->get('db');
        $db->query($sql);
    }

    public function testCanCreateInstance()
    {
        /** @var Shopware_Plugins_Core_Scd16_Bootstrap $plugin */
        $plugin = Shopware()->Plugins()->Core()->Scd16();

        self::assertInstanceOf('Shopware_Plugins_Core_Scd16_Bootstrap', $plugin);
    }
}
