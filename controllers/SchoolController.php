<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\School;

class SchoolController extends Controller
{
	public function actionView($user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id),
        ]);
	}
	
	protected function findModel($id)
    {
        if (($model = School::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}