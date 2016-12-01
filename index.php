<?php
/**
 * phalcon_phpunit.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

use Phalcon\Mvc\Application;

$di = require __DIR__ . '/bootstrap.php';

$application = new Application($di);
$application->useImplicitView(false);

$application->url->setBaseUri('/');

$requestUri = '/';
if (isset($argv[1])) {
    $requestUri = $argv[1];
}

$application->handle($requestUri);
$application->response->send();
