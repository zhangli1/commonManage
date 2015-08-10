<?php

namespace backend\controllers;

use yii\web\Controller;
use common\controllers\DController;

class TestController extends DController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
