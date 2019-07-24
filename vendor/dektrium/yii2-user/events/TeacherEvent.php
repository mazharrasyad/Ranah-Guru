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

use dektrium\user\models\Teacher;
use yii\base\Event;

/**
 * @property Teacher $model
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class TeacherEvent extends Event
{
    /**
     * @var Teacher
     */
    private $_teacher;

    /**
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->_teacher;
    }

    /**
     * @param Teacher $form
     */
    public function setTeacher(Teacher $form)
    {
        $this->_teacher = $form;
    }
}
