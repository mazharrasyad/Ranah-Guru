<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apply".
 *
 * @property int $id
 * @property int $jobvacancy_id
 * @property int $teacher_id
 * @property string $status
 *
 * @property Jobvacancy $jobvacancy
 * @property Teacher $teacher
 */
class Apply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apply';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jobvacancy_id', 'teacher_id', 'status'], 'required'],
            [['jobvacancy_id', 'teacher_id'], 'integer'],
            [['status'], 'string', 'max' => 1],
            [['jobvacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jobvacancy::className(), 'targetAttribute' => ['jobvacancy_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['teacher_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jobvacancy_id' => 'Jobvacancy ID',
            'teacher_id' => 'Teacher ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobvacancy()
    {
        return $this->hasOne(Jobvacancy::className(), ['id' => 'jobvacancy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['user_id' => 'teacher_id']);
    }
}
