<?php

namespace TEiling\Scd16\Cache;

interface CacheInterface
{
    /**
     * Test if a cache is available for the given id
     *
     * @param  string $id Cache id
     *
     * @return int|false Last modified time of cache entry if it is available, false otherwise
     */
    public function test($id);

    /**
     * Save some data in a cache
     *
     * @param  mixed $data Data to put in cache (can be another type than string if automatic_serialization is on)
     * @param  string $id Cache id (if not set, the last cache id will be used)
     * @param  array $tags Cache tags
     * @param  int $specificLifetime If != null, set a specific lifetime for this cache record otherwise infinite
     *         lifetime
     * @param  int $priority integer between 0 (very low priority) and 10 (maximum priority) used by some particular
     *         backends
     *
     * @return boolean True if no problem
     */
    public function save($data, $id = null, $tags = [], $specificLifetime = null, $priority = 8);

    /**
     * Test if a cache is available for the given id and (if yes) return it (false else)
     *
     * @param  string $id Cache id
     * @param  boolean $doNotTestCacheValidity If set to true, the cache validity won't be tested
     * @param  boolean $doNotUnserialize Do not serialize (even if automatic_serialization is true) => for internal use
     *
     * @return mixed|false Cached datas
     */
    public function load($id, $doNotTestCacheValidity = false, $doNotUnserialize = false);
}
