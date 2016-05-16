<?php

use Shopware\Components\Api\Manager;
use TEiling\Scd16\Resource\ArticleResourceInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use TEiling\Scd16\Cache\CacheInterface;
use TEiling\Scd16\Cache\ShopwareCache;

class Shopware_Plugins_Core_Scd16_Container
{

    /** @var ArticleResourceInterface */
    private $articleResource;

    /** @var Zend_Db_Adapter_Abstract */
    private $db;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    private $container;

    /**
     * @var Zend_Cache_Core $cache
     */
    private $cache;

    /**
     * Shopware_Plugins_Core_Scd16_Container constructor.
     *
     * @param ArticleResourceInterface $articleResource
     * @param Zend_Db_Adapter_Abstract $db
     * @param CacheInterface $cache
     *
     * @throws \Exception
     * @throws \Zend_Cache_Exception
     * @throws \Symfony\Component\DependencyInjection\Exception\BadMethodCallException
     */
    public function __construct(
        ArticleResourceInterface $articleResource = null,
        Zend_Db_Adapter_Abstract $db = null,
        CacheInterface $cache = null
    ) {
        $this->articleResource = $articleResource ?? Manager::getResource('Article');
        $this->db = $db ?? Shopware()->Db();
        $this->cache = $cache ?? new ShopwareCache(Shopware()->Cache());

        $cacheId = 'Scd16_Core_Container';

        if ($this->cache->test($cacheId)) {
            eval('?>' . $this->cache->load($cacheId));
            $container = new Scd16ServiceContainer();
        } else {
            $container = $this->createContainer();
            $container->compile();

            $dumper = new PhpDumper($container);
            $dumpParams = [
                'class' => 'Scd16ServiceContainer',
            ];

            $this->cache->save($dumper->dump($dumpParams), $cacheId, ['Shopware_Plugin'], 3600);
        }

        $container->set('article_res', $this->articleResource);
        $container->set('db', $this->db);

        $this->container = $container;
    }

    /**
     * creates a Container
     *
     * @param string $dir
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     * @throws Exception
     */
    public function createContainer($dir = __DIR__)
    {
        $instance = new \Symfony\Component\DependencyInjection\ContainerBuilder();

        $loader = new \Symfony\Component\DependencyInjection\Loader\XmlFileLoader(
            $instance,
            new \Symfony\Component\Config\FileLocator(realpath($dir))
        );
        $loader->load('container.xml');

        $instance->setParameter(
            'config.path.image',
            Shopware()->Plugins()->Core()->Scd16()->Path() . '_vImages/'
        );

        $instance->setParameter(
            'config.path.csv',
            Shopware()->Plugins()->Core()->Scd16()->Path() . 'tests/fixtures/shopexport.csv'
        );

        return $instance;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->get($id);
    }
}
