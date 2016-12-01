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
 * @property Users user
 * @package Model
 */
class Accounts extends Model
{
    public $account_id;

    public $user_id;

    public $username;

    public function initialize()
    {
        $this->belongsTo('user_id', Users::class, 'user_id', ['alias' => 'user']);
    }
}
