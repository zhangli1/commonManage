<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\rbac\DbManager;
use yii\rbac\Item;
use yii\rbac\Assignment;
use backend\models\User;
use backend\models\RoleForm;
use yii\data\ArrayDataProvider;
use common\controllers\DController;
use common\models\Util;

class RoleController extends DController
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'update', 'create', 'AddItem'],
				'rules' => [
				    [
					'allow' => true,
					'actions' => ['index', 'update', 'create', 'AddItem'],
					'roles' => ['author'],
				    ],
				],
			]
		];
	  }


    public function actionIndex()
    {
	$user = new User;
	$provider = $user->getAllRolesData(); 	
        return $this->render('index', [
		'dataProvider' => $provider,
	]);
    }


    public function actionCreate($item_name)
    {
	$mainMenus = $this->mainMenus;	
	$util = new Util;
	$permissions = array_unique($util->getAllMenuContext($mainMenus));	
	$model = new RoleForm;
	$allPermissions = $model->getAllPermissions();
	$data = $model->alreadyGetPermissionByTag($permissions, $allPermissions);
	echo json_encode($data);
    }

    public function actionAddItem()
    {
	$item_name = $_GET['item_name'];
	$items = $_GET['items'];
	
	if(!empty($item_name) && !empty($items))
	{
		$model = new DbManager;
		$Item = new Item;
		foreach(explode(',', $items) as $v){
			$Item->name = $v;
			$Item->type = 2;
			$Item->description=$v;
			if($model->add($Item))
			{
				$model->addChild($model->createRole($item_name), $Item);
			}
		}

	}else{
	}
    }


    public function actionUpdate($item_name)
    {
	$dbmanager = new DbManager;
	$data = $dbmanager->getPermissionsByRole($item_name);	
	$model = new RoleForm;
	$provider = $model->updatePermission($data);
	return $this->render('update', [
		'dataProvider' => $provider 
	]);
    }

}
