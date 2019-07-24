<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school".
 *
 * @property int $user_id
 * @property int $npsn
 * @property int $level_id
 * @property string $name
 * @property string $address
 * @property string $telp
 * @property string $foto
 *
 * @property Jobvacancy[] $jobvacancies
 * @property User $user
 * @property Level $level
 */
class School extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'school';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'npsn', 'level_id'], 'integer'],
            [['address'], 'string'],
            [['name', 'foto'], 'string', 'max' => 45],
            [['telp'], 'string', 'max' => 13],
            [['npsn'], 'unique'],
            [['telp'], 'unique'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Level::className(), 'targetAttribute' => ['level_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'npsn' => 'Npsn',
            'level_id' => 'Level ID',
            'name' => 'Name',
            'address' => 'Address',
            'telp' => 'Telp',
            'foto' => 'Foto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobvacancies()
    {
        return $this->hasMany(Jobvacancy::className(), ['school_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['id' => 'level_id']);
    }
}
