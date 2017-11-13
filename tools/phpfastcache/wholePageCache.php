<?php
require __DIR__."/../../vendor/autoload.php";

use phpFastCache\CacheManager;
use Whoops\Run;

$whoops = new Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$cache = CacheManager::Memcached();

$keyword_webpage = md5($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
// try to get from Cache first.
$resultsItem = $cache->getItem($keyword_webpage);

if(!$resultsItem->isHit()) {
    ob_start();
    /*
        ALL OF YOUR CODE GO HERE
        RENDER YOUR PAGE, DB QUERY, WHATEVER
    */

    // GET HTML WEBPAGE
    $html = ob_get_contents();

    $resultsItem->set($html)->expireAfter(1800);
    $cache->save($resultsItem);
}

echo $resultsItem->get();