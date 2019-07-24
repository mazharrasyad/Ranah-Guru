<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jobvacancy".
 *
 * @property int $id
 * @property int $school_id
 * @property int $lesson_id
 * @property string $description
 *
 * @property Apply[] $applies
 * @property Apply[] $applies0
 * @property School $school
 * @property Lesson $lesson
 */
class Jobvacancy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobvacancy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'lesson_id', 'description'], 'required'],
            [['school_id', 'lesson_id', 'flags'], 'integer'],
            [['description'], 'string'],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['school_id' => 'user_id']],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'School ID',
            'lesson_id' => 'Mata Pelajaran',
            'description' => 'Deskripsi',
            'flags' => 'Pelamar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplies()
    {
        return $this->hasMany(Apply::className(), ['jobvacancy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplies0()
    {
        return $this->hasMany(Apply::className(), ['teacher_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(School::className(), ['user_id' => 'school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['id' => 'lesson_id']);
    }    
}
