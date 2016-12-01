<?php
/**
 * phalcon_test.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace App\Controller;

use App\Model\Accounts;
use App\Model\Parts;
use App\Model\Robots;
use App\Model\RobotsParts;
use App\Model\Users;
use Phalcon\Mvc\Controller;

/**
 */
class RelationsController extends Controller
{
    public function beforeExecuteRoute()
    {
        $this->db->begin();
    }

    public function afterExecuteRoute()
    {
        $this->db->rollback();
    }

    public function hasManyAction()
    {
        $robot = new Robots();
        $robot->name = '机器人hasMany';
        $robot->type = 'B';
        $robot->year = '2016';
        $robotPart = new RobotsParts();
        $robotPart->parts_id = 1;
        $robotPart->created_at = '2016-10-10 00:00:00';
        $robot->robotsParts = [$robotPart];

        $robot->create();
        echo current($robotPart->getMessages()) , PHP_EOL;
    }

    public function belongsToAction()
    {
        $robot = new Robots();
        $robot->name = '机器人belongsTo';
        $robot->type = 'B';
        $robot->year = '2016';

        $robotPart = new RobotsParts();
        $robotPart->parts_id = 1;
        $robotPart->created_at = '2016-10-10 00:00:00';

        $robotPart->robots = $robot;
        var_dump($this->modelsManager->getRelationByAlias(get_class($robotPart), 'robots')->getType());
        $robotPart->create();
        echo current($robotPart->getMessages()) , PHP_EOL;
    }

    public function hasOneAction()
    {
        $user = new Users();

        $user->nickname = 'wuha';
        $user->age = 20;

        $account = new Accounts();
        $account->username = 'wuha';

        $user->account = $account;

        $user->create();
        var_export($user->toArray());
        var_export($account->toArray());
        echo current($user->getMessages()) , PHP_EOL;
        echo str_pad('', 100, '-') , PHP_EOL;

        $user = new Users();

        $user->nickname = 'wuha1';
        $user->age = 20;

        $account = new Accounts();
        $account->username = 'wuha1';

        $account->user = $user;

        $account->create();
        var_export($user->toArray());
        var_export($account->toArray());
        echo current($account->getMessages()) , PHP_EOL;
    }

    public function hasManyToManyAction()
    {
        $robot = new Robots();
        $robot->name = '机器人belongsTo';
        $robot->type = 'B';
        $robot->year = '2016';

        $part = Parts::findFirstByName('手');
        $robot->parts = [$part];
        // 因为中间表 RobotsParts 表里还有一个字段是 created_at，需要在 RobotsParts 的事件中加上。否则会报错。
        $robot->create();

        $errorMessage = current($robot->getMessages());
        // @todo 搞懂为什么会 Message 的 model 会是一个数组。
        var_dump($errorMessage->getModel());
        if (!empty($errorMessage)) {
            echo $errorMessage->getMessage() . PHP_EOL;
        }
    }
}
