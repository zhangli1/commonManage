<?php

namespace backend\models;

use yii\data\ArrayDataProvider;
use yii\db\Connection;
use yii\db\Query;

class RoleForm  
{
	/*
	 * 更新权限
	 * $data Array
	 */
	public function updatePermission($data)
	{
		foreach($data as $v)
		{
			$arr[] = ['name'=>$v->name, 'description'=>$v->description];
		}
		$provider = new ArrayDataProvider([
			'allModels' => $arr,
			'sort' => [
				'attributes'=> ['name', 'description'],
			],
			'pagination' => ['pageSize' => 10]
		]);
		return $provider;
	}


	/*
	 * 添加权限
	 * $permissions Array
	 */

	public function addPermission($data)
	{
		$arr = [];
		foreach($data as $k => $v)
		{
			$arr[] = ['permission' => $v['permission'], 'description'=>'', 'isExist'=>$v['isExist']];		
		}
		$provider = new ArrayDataProvider([
			'allModels' => $arr,
			'sort' => [
				'attributes'=> ['permission', 'description'],
			],
			'pagination' => ['pageSize' => 10]
		]);
		return $provider;
	}


	/*
	 * 获取所有权限
	 */

	public function getAllPermissions()
	{
		$data = [];
		$arrData = (new Query)->select('name')
		    ->from('auth_item')
		    ->where("type!= 1")->all();
		foreach($arrData as $v)
		{
			$data[] = $v['name'];	
		}
		return $data;
	}


	/*
	 * 将已经获得的权限做下标记
	 */
	public function alreadyGetPermissionByTag($permissions, $allPermissions)
	{
		$arr = [];
		foreach($permissions as $k => $v)
		{
			if(!in_array($v, $allPermissions))
				$arr[] = $v;
				
		}	
		return $arr;
	}
}	
