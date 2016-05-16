<?php

namespace TEiling\Scd16\Cache;

use Zend_Cache_Core;

class ShopwareCache implements CacheInterface
{
    /** @var Zend_Cache_Core */
    private $shopwareCache;

    /**
     * DummyCache constructor.
     *
     * @param Zend_Cache_Core $shopwareCache
     */
    public function __construct(Zend_Cache_Core $shopwareCache)
    {
        $this->shopwareCache = $shopwareCache;
    }

    /**
     * @inheritdoc
     */
    public function test($id)
    {
        return $this->shopwareCache->test($id);
    }

    /**
     * @inheritdoc
     * @throws \Zend_Cache_Exception
     */
    public function save($data, $id = null, $tags = [], $specificLifetime = null, $priority = 8)
    {
        return $this->shopwareCache->save($data, $id, $tags, $specificLifetime, $priority);
    }

    /**
     * @inheritdoc
     */
    public function load($id, $doNotTestCacheValidity = false, $doNotUnserialize = false)
    {
        return $this->shopwareCache->load($id, $doNotTestCacheValidity, $doNotUnserialize);
    }
}
