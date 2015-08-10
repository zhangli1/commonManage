<?php

namespace common\models;

use yii;
use yii\base\Exception;

class Util
{
	public $permissions = [];
	//获取所有menu
	public function getAllMenuContext($allMenu = [])
	{
		$this->getLoopArray($allMenu);	
		return $this->permissions;
	}


	// 递归遍历所有菜单项
	private function getLoopArray($arr)
	{
		foreach ( $arr as $k => $v)
		{
			if (isset($v['url']) && !empty($v['url'][0]))
			{
				array_push($this->permissions, urlencode($v['url'][0]));
			}
			
			if (isset($v['items']) && !empty($v['items']))
			{
				$this->getLoopArray($v['items']);
			} else {
				continue;
			}
		}


	}
}
