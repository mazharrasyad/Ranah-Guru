<?php

namespace dektrium\user\models;

use dektrium\user\traits\ModuleTrait;
use yii\db\ActiveRecord;

class Teacher extends ActiveRecord
{
    use ModuleTrait;
    
    protected $module;
    public $cvFile;
    public $fotoFile;

    public function init()
    {
        $this->module = \Yii::$app->getModule('user');
    }

    public function getAvatarUrl($size = 200)
    {
        return '//gravatar.com/avatar/' . $this->gravatar_id . '?s=' . $size;
    }

    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }

    public function rules()
    {
        return [
            'nuptkLength'        => ['nuptk', 'integer', 'max' => 9999999999999999],
            'nameLength'         => ['name', 'string', 'max' => 255],
            'birthdate'          => ['birthdate', 'safe'],
            'religion_idLength'  => ['religion_id', 'string', 'max' => 255],
            'addressString'      => ['address', 'string'],
            'telpLength'         => ['telp', 'integer', 'max' => 9999999999999],            
            'cvFile'             => [['cvFile'], 'file',
                                        'skipOnEmpty' => true,
                                        'extensions' => 'pdf, docx, doc, odt',
                                        'minSize' => 10240, //minimal 10 kb = 10240 Byte
                                        'maxSize' => 512000, //Maksimal 500kb = 512000 Byte
                                    ],
            'fotoFile'             => [['fotoFile'], 'file',
                                        'skipOnEmpty' => true,
                                        'extensions' => 'png, jpg, jpeg',
                                        'minSize' => 10240, //minimal 10 kb = 10240 Byte
                                        'maxSize' => 512000, //Maksimal 500kb = 512000 Byte
                                    ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nuptk'          => \Yii::t('user', 'Nomor Unik Pendidik dan Tenaga Kependidikan'),
            'name'           => \Yii::t('user', 'Nama'),
            'birthdate'      => \Yii::t('user', 'Tanggal Lahir'),
            'religion_id'    => \Yii::t('user', 'Agama'),
            'address'        => \Yii::t('user', 'Alamat'),
            'telp'           => \Yii::t('user', 'Nomor Telephone'),
            'cv'             => \Yii::t('user', 'Curiculum Vitae'),
            'cvFile'         => \Yii::t('user', 'Curiculum Vitae'),
            'foto'           => \Yii::t('user', 'Foto'),
            'fotoFile'       => \Yii::t('user', 'Foto'),
        ];
    }

    public function validateTimeZone($attribute, $params)
    {
        if (!in_array($this->$attribute, timezone_identifiers_list())) {
            $this->addError($attribute, \Yii::t('user', 'Time zone is not valid'));
        }
    }

    public function getTimeZone()
    {
        try {
            return new \DateTimeZone($this->timezone);
        } catch (\Exception $e) {
            // Default to application time zone if the user hasn't set their time zone
            return new \DateTimeZone(\Yii::$app->timeZone);
        }
    }
    
    public function setTimeZone(\DateTimeZone $timeZone)
    {
        $this->setAttribute('timezone', $timeZone->getName());
    }

    public function toLocalTime(\DateTime $dateTime = null)
    {
        if ($dateTime === null) {
            $dateTime = new \DateTime();
        }

        return $dateTime->setTimezone($this->getTimeZone());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isAttributeChanged('gravatar_email')) {
            $this->setAttribute('gravatar_id', md5(strtolower(trim($this->getAttribute('gravatar_email')))));
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%teacher}}';
    }
}
