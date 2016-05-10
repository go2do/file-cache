<?php

include 'FileCache.php';

//存储字符串
$key = 'file-str';
$value = 'Test string';
$fileCache1 = new FileCache();
$fileCache1->set($key, $value);
$data = $fileCache1->get($key);
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
$fileCache2 = new FileCache();
$fileCache2->set($key, $value);
$data = $fileCache2->get($key);
if ($data !== false) {
    echo 'Success! ';
    print_r($data);
}else{
    echo 'Failed!';
}
echo '<br>';

//已过期的文件缓存
$key = 'file-expired';
$fileCache3 = new FileCache();
$data = $fileCache3->get($key);
if ($data === false) {
    echo 'Success! The file cache has expired.';
}else{
    echo 'Failed!';
}
echo '<br>';

//空key验证
$key = '';
$value = array('empty key');
$fileCache4 = new FileCache();
$isCache = $fileCache4->set($key, $value);
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
$isCache = $fileCache5->set($key, $value);
print_r($isCache);
if ($isCache === false) {
    echo 'Success! The key must be string type.';
}else{
    echo 'Failed!';
}
echo '<br>';