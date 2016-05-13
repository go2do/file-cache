<?php

include '../FileCache.php';

$fileCache = new FileCache();
$fileCache->setCacheDir('/data0/php/file-cache/cache/files');

//存储字符串
$key = 'file-str';
$value = 'Test string';
$m = $fileCache->set($key, $value);
$data = $fileCache->get($key);

if ($data !== false) {
    echo 'Success! ';
    print_r($data);
}else{
    echo 'Failed!';
}
echo '<br>';

//存储多维数组
$key = 'file-multi-arr';
$value = array('123', 'hello' => array('OK'));
$fileCache->set($key, $value);
$data = $fileCache->get($key);
if ($data !== false) {
    echo 'Success! ';
    print_r($data);
}else{
    echo 'Failed!';
}
echo '<br>';

//已过期的文件缓存
$key = 'file-expired';
$data = $fileCache->getCacheFromFile('./file-expired');
if ($data === false) {
    echo 'Success! The file cache has expired.';
}else{
    echo 'Failed!';
}
echo '<br>';

//空key验证
$key = '';
$value = array('empty key');
$isCache = $fileCache->set($key, $value);
print_r($isCache);
if ($isCache === false) {
    echo 'Success! Empty key can not be saved.';
}else{
    echo 'Failed!';
}
echo '<br>';

//Valid key must be string
$key = 123;
$value = array('empty key');
$fileCache5 = new FileCache();
$isCache = $fileCache->set($key, $value);
if ($isCache === false) {
    echo 'Success! The key must be string type.';
}else{
    echo 'Failed!';
}
echo '<br>';
