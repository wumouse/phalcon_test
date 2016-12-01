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
 * @property RobotsParts[] robotsParts
 * @property Parts[] parts
 */
class Robots extends Model
{
    public $id;

    public $name;

    public $type;

    public $year;

    public function initialize()
    {
        $this->hasMany(
            "id",
            RobotsParts::class,
            "robots_id",
            ['alias' => 'robotsParts']
        );

        $this->hasManyToMany(
            'id',
            RobotsParts::class,
            'robots_id',
            'parts_id',
            Parts::class,
            'id',
            ['alias' => 'parts']
        );
    }
}
