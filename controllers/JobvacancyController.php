<?php

namespace app\controllers;

use Yii;
use app\models\Jobvacancy;
use app\models\JobvacancySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Apply;
use app\models\School;

/**
 * JobvacancyController implements the CRUD actions for Jobvacancy model.
 */
class JobvacancyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Jobvacancy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobvacancySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $jobvacancies = Jobvacancy::find()->all();
        $applies = Apply::find()->all();
        $user = School::findOne(['user_id' => Yii::$app->user->identity->id]);		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'jobvacancies' => $jobvacancies,
            'applies' => $applies,
            'user' => $user,
        ]);
    }

    /**
     * Displays a single Jobvacancy model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$jobvacancies = Jobvacancy::find()->all();
        $applies = Apply::find()->all();
        
        $flag = Jobvacancy::findOne(['id' => $id]);
		$flag->flags = 0;
		$flag->save();

        return $this->render('view', [
            'model' => $this->findModel($id),
			'jobvacancies' => $jobvacancies,
			'applies' => $applies,
        ]);
    }

    /**
     * Creates a new Jobvacancy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jobvacancy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jobvacancy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jobvacancy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Jobvacancy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jobvacancy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jobvacancy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
