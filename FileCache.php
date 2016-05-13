<?php

Class FileCache
{

    //$cache_dir is absolute or relative path
    private $cache_dir = '/tmp/file_cache';

    public function setCacheDir($dir){
        return $this->cache_dir = $dir . '/';
    }

    /**
     * @param string $key
     * @return mixed If get failed return false, else return the set value
     */
    public function get($key)
    {
        if ($this->filterKey($key) === false) {
            return false;
        }

        $path = $this->getCachePath($key);
        return $this->getCache($path);
    }

    /**
     * @param string $path file path
     * @return bool
     */
    public function getCacheFromFile($path){
        return $this->getCache($path);
    }

    private function getCache($path){
        if (!file_exists($path)) {
            return false;
        }

        $file = file_get_contents($path);
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

        $filename = $this->setCacheFile($key);
        
        $data = array(
            'expire' => time() + $expire,
            'value' => $value,
        );
        return file_put_contents($filename, serialize($data), LOCK_EX);
    }

    private function getCachePath($key){
        $fileDir = $this->cache_dir . substr(md5($key), 0, 2);
        $path = $fileDir . '/' . $key;
        return $path;
    }

    private function setCacheFile($key){
        $fileDir = $this->cache_dir . substr(md5($key), 0, 2);

        if(!is_dir($fileDir) && !mkdir($fileDir , 0777, true)){
            return false;
        }

        $filename = $fileDir . '/' . $key;
        return $filename;
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
