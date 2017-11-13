<?php
require __DIR__."/../../vendor/autoload.php";
use phpFastCache\CacheManager;
use Whoops\Run;
$whoops = new Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$memCache = CacheManager::getInstance("memcached");
$redisCache = CacheManager::getInstance("redis");
$filesCache = CacheManager::getInstance("Files");

/**
 * Get Items
 */
$memCacheItem1 = $memCache->getItem('item1');
$memCacheItem2 = $memCache->getItem('item2');
$memCacheItem3 = $memCache->getItem('item3');

$redisCacheItem1 = $redisCache->getItem('item1');
$redisCacheItem2 = $redisCache->getItem('item2');
$redisCacheItem3 = $redisCache->getItem('item3');

$filesCacheItem1 = $filesCache->getItem('item1');
$filesCacheItem2 = $filesCache->getItem('item2');
$filesCacheItem3 = $filesCache->getItem('item3');

/**
 * Set Items
 */
$memCacheItem1->set('test1');
$memCacheItem2->set('test2');
$memCacheItem3->set('test3');

$redisCacheItem1->set('test1');
$redisCacheItem2->set('test2');
$redisCacheItem3->set('test3');

$filesCacheItem1->set('test1');
$filesCacheItem2->set('test2');
$filesCacheItem3->set('test3');

/**
 * Save Items
 */
$memCache->save($memCacheItem1);
$memCache->save($memCacheItem2);
$memCache->save($memCacheItem3);

$redisCache->save($redisCacheItem1);
$redisCache->save($redisCacheItem2);
$redisCache->save($redisCacheItem3);

$filesCache->save($filesCacheItem1);
$filesCache->save($filesCacheItem2);
$filesCache->save($filesCacheItem3);