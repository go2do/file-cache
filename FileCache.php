<?php

Class FileCache
{

    //$cache_dir is absolute or relative path
    private $cache_dir = 'cache/files/';

    /**
     * @param string $key
     * @return mixed If get failed return false, else return the set value
     */
    public function get($key)
    {
        if ($this->filterKey($key) === false) {
            return false;
        }

        $filename = $this->cache_dir . $key;
        if (!file_exists($filename)) {
            return false;
        }

        $file = file_get_contents($filename);
        $data = unserialize($file);

        if (isset($data['expire']) && isset($data['value']) && time() <= $data['expire']) {
            return $data['value'];
        } else {
            return false;
        }
    }

    /**
     * @param string $key
     * @param $value
     * @param int $expire
     * @return bool|int If set failed return false else return the number of bytes
     * that were written to the file
     */
    public function set($key, $value, $expire = 3600)
    {
        if ($this->filterKey($key) === false) {
            return false;
        }

        if (!is_int($expire) || $expire < 0) {
            return false;
        }

        $filename = $this->cache_dir . $key;
        $data = array(
            'expire' => time() + $expire,
            'value' => $value,
        );
        return file_put_contents($filename, serialize($data), LOCK_EX);
    }

    private function filterKey($key)
    {
        if (is_string($key) && strlen($key) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
