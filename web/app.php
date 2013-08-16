<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

require_once __DIR__.'/../app/AppKernel.php';

$app = new AppKernel('prod', false);
$app->loadClassCache();

// Prevent debug mode to be available on a production server.
if (!isset($_SERVER['HTTP_CLIENT_IP'])
    && !isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    && in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
) {
    Debug::enable();
    $debugApplication = new AppKernel('dev', true);

    $stack = new Stack\Builder();
    $stack->push('Stack\UrlMap', array('/debug' => $debugApplication));

    $app = $stack->resolve($app);
}

$request = Request::createFromGlobals();
$response = $app->handle($request);
$response->send();
$app->terminate($request, $response);
