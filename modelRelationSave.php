<?php
/**
 * phalcon_phpunit.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

use Model\Robots;
use Model\RobotsParts;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;
use Phalcon\Events\Manager;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Model\Validator\PresenceOf;

/**
 *
 */
class ModelRelationSave extends Phalcon\Mvc\Controller
{
    public function saveHasMany()
    {
        echo str_pad('', 100, '-') , PHP_EOL , __METHOD__ , PHP_EOL;
        $robot = new Robots();
        $robot->name = '机器人B';
        $robot->type = 'B';
        $robot->year = '2016';
        $robotPart = new RobotsParts();
        $robotPart->parts_id = 1;
        $robotPart->created_at = '2016-10-10 00:00:00';
        $robot->robotsParts = [$robotPart];

        $robot->create();
        echo current($robot->getMessages()) , PHP_EOL;
    }

    public function saveBelongsTo()
    {
        echo str_pad('', 100, '-') , PHP_EOL , __METHOD__ , PHP_EOL;
        $robot = Robots::findFirst(4);
        $robotPart = new RobotsParts();
        $robotPart->parts_id = 1;
        $robotPart->created_at = '2016-10-10 00:00:00';

        $robotPart->robots = $robot;
        $robotPart->create();
        echo current($robotPart->getMessages()) , PHP_EOL;
    }

    public function saveHasOne()
    {
        echo str_pad('', 100, '-') , PHP_EOL , __METHOD__ , PHP_EOL;
        $robot = Robots::findFirst(4);
        $robotPart = new RobotsParts();
        $robotPart->parts_id = 1;
        $robotPart->created_at = '2016-10-10 00:00:00';

        $robotPart->robots = $robot;
        $robotPart->create();
        echo current($robotPart->getMessages()) , PHP_EOL;
    }
}

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
        if (in_array(substr($connection->getSQLStatement(), 0, 8), ['INSERT I', 'SELECT `'])) {
            echo $connection->getSQLStatement(), PHP_EOL;
            echo var_export($connection->getSqlVariables()) . PHP_EOL;
        }
    });
    $db->setEventsManager($eventsManager);

    return $db;
}, true);

$loader = new Loader();
$loader->registerNamespaces([
    'Model' => __DIR__ . '/Model',
]);
$loader->register();

$obj = new ModelRelationSave();
$obj->saveHasMany();
$obj->saveBelongsTo();
