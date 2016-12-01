<?php
/**
 * phalcon_phpunit.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace App\Model;

use Phalcon\Mvc\Model;

/**
 * @method static Parts findFirstByName($params = null)
 * @package App\Model
 */
class Parts extends Model
{
    public $id;

    public $name;

    public $created_at;

    public function initialize()
    {
        $this->hasMany(
            "id",
            "RobotsParts",
            "parts_id"
        );
    }
}
