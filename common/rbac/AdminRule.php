<?php

namespace common\rbac; 


use yii\rbac\Rule;

class AdminRule extends Rule 
{

	public function execute($user, $item, $params)
	{
		if(isset($item) && $item->name == '超级管理员')
		{
			return true;
		}	
		return false;
	}
}
