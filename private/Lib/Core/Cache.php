<?php

namespace Lib\Core;


class Cache extends Singleton
{
    /**
     * @var array
     */
    private $requestCache = [];

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (isset($this->requestCache[$key])) {
            return $this->requestCache[$key];
        }

        $tmpFile = $this->getTmpFileForKey($key);

        if (file_exists($tmpFile)) {
            return unserialize(file_get_contents($tmpFile));
        }

        return $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->requestCache[$key] = $value;
        $tmpFile = $this->getTmpFileForKey($key);
        if (file_exists($tmpFile)) {
            unlink($tmpFile);
        }

        file_put_contents($tmpFile, serialize($value));
    }

    /**
     * @param string $key
     */
    public function unset($key)
    {
        if (isset($this->requestCache[$key])) {
            unset($this->requestCache[$key]);
        }

        $tmpFile = $this->getTmpFileForKey($key);
        if (file_exists($tmpFile)) {
            unlink($tmpFile);
        }
    }

    /**
     * @param string $key
     * @return string
     */
    private function getTmpFileForKey($key)
    {
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . md5($key) . '.cache';
    }
}