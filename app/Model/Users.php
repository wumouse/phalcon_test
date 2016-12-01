<?php
/**
 * phalcon_test.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace App\Model;

use Phalcon\Mvc\Model;

/**
 * @property Users account
 * @package App\Model
 */
class Users extends Model
{
    public $user_id;

    public $nickname;

    public $age;

    public function initialize()
    {
        $this->hasOne('user_id', Accounts::class, 'user_id', ['alias' => 'account']);
    }
}
