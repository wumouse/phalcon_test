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
 * @property Robots robots
 */
class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public $created_at;

    public function initialize()
    {
        $this->belongsTo(
            "robots_id",
            Robots::class,
            "id",
            ['alias' => 'Robots']
        );

        $this->belongsTo(
            "parts_id",
            Parts::class,
            "id",
            ['alias' => 'Parts']
        );
    }

    public function beforeValidationOnCreate()
    {
        if (!$this->created_at) {
            // $this->created_at = date('Y-m-d H:i:s');
        }
    }
}
