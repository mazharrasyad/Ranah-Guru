<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dektrium\user\controllers;

use Yii;
use dektrium\user\Finder;
use dektrium\user\models\Profile;
use dektrium\user\models\SettingsForm;
use dektrium\user\models\User;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use dektrium\user\models\School;
use dektrium\user\models\Teacher;
use yii\web\UploadedFile;

class SettingsController extends Controller
{
    use AjaxValidationTrait;
    use EventTrait;

    const EVENT_BEFORE_PROFILE_UPDATE = 'beforeProfileUpdate';

    const EVENT_AFTER_PROFILE_UPDATE = 'afterProfileUpdate';

    /**
     * Event is triggered before updating user's account settings.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_BEFORE_ACCOUNT_UPDATE = 'beforeAccountUpdate';

    /**
     * Event is triggered after updating user's account settings.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_ACCOUNT_UPDATE = 'afterAccountUpdate';

    /**
     * Event is triggered before changing users' email address.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_CONFIRM = 'beforeConfirm';

    /**
     * Event is triggered after changing users' email address.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONFIRM = 'afterConfirm';

    /**
     * Event is triggered before disconnecting social account from user.
     * Triggered with \dektrium\user\events\ConnectEvent.
     */
    const EVENT_BEFORE_DISCONNECT = 'beforeDisconnect';

    /**
     * Event is triggered after disconnecting social account from user.
     * Triggered with \dektrium\user\events\ConnectEvent.
     */
    const EVENT_AFTER_DISCONNECT = 'afterDisconnect';

    /**
     * Event is triggered before deleting user's account.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_DELETE = 'beforeDelete';

    /**
     * Event is triggered after deleting user's account.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_DELETE = 'afterDelete';

    /** @inheritdoc */
    public $defaultAction = 'school';

    /** @var Finder */
    protected $finder;

    /**
     * @param string           $id
     * @param \yii\base\Module $module
     * @param Finder           $finder
     * @param array            $config
     */
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'disconnect' => ['post'],
                    'delete'     => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'networks', 'disconnect', 'delete', 'school', 'teacher'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['confirm'],
                        'roles'   => ['?', '@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionProfile()
    {
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        if ($model == null) {
            $model = \Yii::createObject(Profile::className());
            $model->link('user', \Yii::$app->user->identity);
        }

        $event = $this->getProfileEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
     * Displays page where user can update account settings (username, email or password).
     *
     * @return string|\yii\web\Response
     */
    public function actionAccount()
    {
        /** @var SettingsForm $model */
        $model = \Yii::createObject(SettingsForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_ACCOUNT_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
            $this->trigger(self::EVENT_AFTER_ACCOUNT_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }

    /**
     * Attempts changing user's email address.
     *
     * @param int    $id
     * @param string $code
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->emailChangeStrategy == Module::STRATEGY_INSECURE) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);
        $user->attemptEmailChange($code);
        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        return $this->redirect(['account']);
    }

    /**
     * Displays list of connected network accounts.
     *
     * @return string
     */
    public function actionNetworks()
    {
        return $this->render('networks', [
            'user' => \Yii::$app->user->identity,
        ]);
    }

    /**
     * Disconnects a network account from user.
     *
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDisconnect($id)
    {
        $account = $this->finder->findAccount()->byId($id)->one();

        if ($account === null) {
            throw new NotFoundHttpException();
        }
        if ($account->user_id != \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $event = $this->getConnectEvent($account, $account->user);

        $this->trigger(self::EVENT_BEFORE_DISCONNECT, $event);
        $account->delete();
        $this->trigger(self::EVENT_AFTER_DISCONNECT, $event);

        return $this->redirect(['networks']);
    }

    /**
     * Completely deletes user's account.
     *
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete()
    {
        if (!$this->module->enableAccountDelete) {
            throw new NotFoundHttpException(\Yii::t('user', 'Not found'));
        }

        /** @var User $user */
        $user  = \Yii::$app->user->identity;
        $event = $this->getUserEvent($user);

        \Yii::$app->user->logout();

        $this->trigger(self::EVENT_BEFORE_DELETE, $event);
        $user->delete();
        $this->trigger(self::EVENT_AFTER_DELETE, $event);

        \Yii::$app->session->setFlash('info', \Yii::t('user', 'Your account has been completely deleted'));

        return $this->goHome();
    }

    // Sekolah

    const EVENT_BEFORE_SCHOOL_UPDATE = 'beforeSchoolUpdate';
    const EVENT_AFTER_SCHOOL_UPDATE = 'afterSchoolUpdate';

    public function actionSchool()
    {
        $model = $this->finder->findSchoolById(\Yii::$app->user->identity->getId());

        if ($model == null) {
            $model = \Yii::createObject(School::className());
            $model->link('user', \Yii::$app->user->identity);
        }

        $event = $this->getSchoolEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_SCHOOL_UPDATE, $event);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');

            if($model->validate() && !empty($model->fotoFile)){
                $nama1 = 'foto-'.$model->user_id.'.'.$model->fotoFile->extension;
                $model->foto = $nama1;
                $model->save();
                $model->fotoFile->saveAs('foto/'.$nama1);
            }
            else{
                $model->save();
            }            

            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Profil sekolah berhasil diperbaharui'));
            $this->trigger(self::EVENT_AFTER_TEACHER_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('school', [
            'model' => $model,
        ]);
    }

    // Guru

    const EVENT_BEFORE_TEACHER_UPDATE = 'beforeTeacherUpdate';
    const EVENT_AFTER_TEACHER_UPDATE = 'afterTeacherUpdate';

    public function actionTeacher()
    {
        $model = $this->finder->findTeacherById(\Yii::$app->user->identity->getId());        

        if ($model == null) {
            $model = \Yii::createObject(Teacher::classNames());
            $model->link('user', \Yii::$app->user->identity);
        }

        $event = $this->getTeacherEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_TEACHER_UPDATE, $event);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->cvFile = UploadedFile::getInstance($model, 'cvFile');
            $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');

            if($model->validate() && !empty($model->fotoFile) && !empty($model->cvFile)){
                $nama2 = 'cv-'.$model->user_id.'.'.$model->cvFile->extension;;
                $model->cv = $nama2;
                $nama1 = 'foto-'.$model->user_id.'.'.$model->fotoFile->extension;;
                $model->foto = $nama1;
                $model->save();
                $model->cvFile->saveAs('cv/'.$nama2);            
                $model->fotoFile->saveAs('foto/'.$nama1);
            }
            else if($model->validate() && !empty($model->fotoFile)){
                $nama1 = 'foto-'.$model->user_id.'.'.$model->fotoFile->extension;
                $model->foto = $nama1;
                $model->save();
                $model->fotoFile->saveAs('foto/'.$nama1);
            }
            else if($model->validate() && !empty($model->cvFile)){
                $nama2 = 'cv-'.$model->user_id.'.'.$model->cvFile->extension;;
                $model->cv = $nama2;
                $model->save();
                $model->cvFile->saveAs('cv/'.$nama2);
            }
            else{
                $model->save();
            }            

            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Profil guru berhasil diperbaharui'));
            $this->trigger(self::EVENT_AFTER_TEACHER_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('teacher', [
            'model' => $model,
        ]);
    }
}
