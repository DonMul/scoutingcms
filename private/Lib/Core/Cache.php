<?php

namespace Lib\Core;

/**
 * Class Cache
 * @package Lib\Core
 */
class Cache extends \Lib\Core\Singleton
{
    /**
     * @var array
     */
    private $tmpCache = [];

    /**
     * @var \Memcached
     */
    private $memcached = null;

    /**
     *
     */
    protected function __construct()
    {
        $this->memcached = new \Memcached(\Lib\Core\Settings::getInstance()->get(['memcached', $_SERVER['SERVER_ADDR']]));
        $this->memcached->addServer('node0.posd.io', 11211);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param int    $expiration
     */
    public function set($key, $value, $expiration = null)
    {
        $this->memcached->set($key, $value, 0, $expiration);
        $this->tmpCache[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if (isset($this->tmpCache[$key])) {
            return $this->tmpCache[$key];
        }

        return $this->memcached->get($key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function has($key)
    {
        if (isset($this->tmpCache[$key])) {
            return $this->tmpCache[$key];
        }

        $val = $this->get($key);
        if ($val) {
            $this->tmpCache[$key] = $val;
        }

        return $val;
    }
}
