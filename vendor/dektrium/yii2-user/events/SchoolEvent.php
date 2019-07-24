<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dektrium\user\events;

use dektrium\user\models\School;
use yii\base\Event;

/**
 * @property School $model
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SchoolEvent extends Event
{
    /**
     * @var School
     */
    private $_school;

    /**
     * @return School
     */
    public function getSchool()
    {
        return $this->_school;
    }

    /**
     * @param School $form
     */
    public function setSchool(School $form)
    {
        $this->_school = $form;
    }
}
