<?php

namespace backend\controllers;

use backend\models\User; 
use common\controllers\DController;

class SignInController extends DController
{
    public function actionIndex()
    {
	$model = new User;
	if ( $model->load(\Yii::$app->request->post()) && $model->signIn() )
	{
		return $this->redirect(['site/login']);
	}
	else 
	{
	}
        return $this->render('index', ['model' => $model]);
    }

}
