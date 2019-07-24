<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property int $user_id
 * @property int $nuptk
 * @property string $name
 * @property string $birthdate
 * @property int $religion_id
 * @property string $telp
 * @property string $address
 * @property string $cv
 * @property string $foto
 *
 * @property Apply[] $applies
 * @property User $user
 * @property Religion $religion
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'nuptk', 'religion_id'], 'integer'],
            [['birthdate'], 'safe'],
            [['address'], 'string'],
            [['name', 'cv', 'foto'], 'string', 'max' => 45],
            [['telp'], 'string', 'max' => 13],
            [['nuptk'], 'unique'],
            [['telp'], 'unique'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['religion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Religion::className(), 'targetAttribute' => ['religion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'nuptk' => 'Nuptk',
            'name' => 'Name',
            'birthdate' => 'Birthdate',
            'religion_id' => 'Religion ID',
            'telp' => 'Telp',
            'address' => 'Address',
            'cv' => 'Cv',
            'foto' => 'Foto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplies()
    {
        return $this->hasMany(Apply::className(), ['teacher_id' => 'user_id']);
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
    public function getReligion()
    {
        return $this->hasOne(Religion::className(), ['id' => 'religion_id']);
    }
}
