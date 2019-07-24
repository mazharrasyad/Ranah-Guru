<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\Apply;
use app\models\Teacher;
use app\models\Jobvacancy;
use app\models\JobvacancySearch;
use dektrium\user\models\User;

class ApplyController extends Controller
{
	public function actionCreate($jobvacancy_id)
	{
		$flag = Jobvacancy::findOne(['id' => $jobvacancy_id]);
		$flag->flags = $flag->flags + 1;
		$flag->save();
		$model = new Apply;				
		$model->jobvacancy_id = $jobvacancy_id;
		$model->teacher_id = Yii::$app->user->identity->id;
		$model->status = 'M';
		$model->load(Yii::$app->request->post());
		$model->save();
		Yii::$app->session->setFlash('success','Berhasil Melamar');						
		return $this->redirect(['index']);
	}

	public function actionTerima($jobvacancy_id, $teacher_id)
	{
		$model = Apply::findOne(['jobvacancy_id' => $jobvacancy_id, 'teacher_id' => $teacher_id]);					
		$model->status = 'Y';
		$flag = User::findOne(['id' => $teacher_id]);
		$flag->flags = $flag->flags + 1;
		$flag->save();
		$model->save();			
		Yii::$app->session->setFlash('success','Lamaran diTerima');			
		return $this->redirect(['/jobvacancy']);												
	}

	public function actionTolak($jobvacancy_id, $teacher_id)
	{
		$model = Apply::findOne(['jobvacancy_id' => $jobvacancy_id, 'teacher_id' => $teacher_id]);					
		$model->status = 'N';
		$flag = User::findOne(['id' => $teacher_id]);
		$flag->flags = $flag->flags + 1;
		$flag->save();
		$model->save();
		Yii::$app->session->setFlash('danger','Lamaran diTolak');			
		return $this->redirect(['/jobvacancy']);												
	}

	public function actionBatal($jobvacancy_id)
	{
		$model = Apply::findOne(['jobvacancy_id' => $jobvacancy_id]);							
		$model->delete();
		Yii::$app->session->setFlash('danger','Lamaran dibatalkan');			
		return $this->redirect(['/apply']);												
	}

	public function actionIndex()
	{
		$searchModel = new JobvacancySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$jobvacancies = Jobvacancy::find()->all();
		$applies = Apply::find()->all();
		$user = Teacher::findOne(['user_id' => Yii::$app->user->identity->id]);		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'jobvacancies' => $jobvacancies,
			'applies' => $applies,
			'user' => $user,
        ]);
	}

	public function actionNotification()
	{				
		$flag = User::findOne(['id' => Yii::$app->user->identity->id]);
		$flag->flags = 0;
		$flag->save();		
		return $this->redirect(['/apply']);												
	}
}