<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

require_once __DIR__.'/../app/AppKernel.php';

$app = new AppKernel('prod', false);
$app->loadClassCache();

$isOnProductionServer = isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1')
);

if (!$isOnProductionServer) {
    Debug::enable();

    $stack = new Stack\Builder();
    $stack->push('Stack\UrlMap', array('/dev' => new AppKernel('dev', true)));
    $stack->push('Stack\UrlMap', array('/test' => new AppKernel('test', true)));

    $app = $stack->resolve($app);
}

Stack\run($app);
