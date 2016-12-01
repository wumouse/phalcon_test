<?php

use Phalcon\Db\Adapter\Pdo;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;
use Phalcon\Events\Manager;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;

$di = new Di\FactoryDefault();
$di->set('db', function () {
    $db = new Mysql([
        'host'     => 'localhost',
        'dbname'   => 'phalcon_test',
        'port'     => 3306,
        'username' => 'root',
        'password' => ''
    ]);

    /** @var Manager $eventsManager */
    $eventsManager = $this->getEventsManager();
    $eventsManager->attach('db:beforeQuery', function ($event, Pdo $connection) {
        $sql = $connection->getSQLStatement();
        if (0 !== strpos($sql, 'DESCRIBE') && 0 !== strpos($sql, 'SELECT IF')) {
            echo $connection->getSQLStatement(), PHP_EOL;
            echo var_export($connection->getSqlVariables()) . PHP_EOL;
        }
    });
    $db->setEventsManager($eventsManager);

    return $db;
}, true);

$loader = new Loader();
$loader->registerNamespaces([
    'App' => __DIR__ . '/app',
]);
$loader->register();

/** @var Dispatcher $dispatcher */
$dispatcher = $di->get('dispatcher');
$dispatcher->setDefaultNamespace('App\\Controller');

return $di;
