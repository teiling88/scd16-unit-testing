<?php

namespace TEiling\Scd16\Cache;

class DummyCache implements CacheInterface
{
    /**
     * @inheritdoc
     */
    public function test($id)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function save($data, $id = null, $tags = [], $specificLifetime = null, $priority = 8)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function load($id, $doNotTestCacheValidity = false, $doNotUnserialize = false)
    {
        return false;
    }
}
