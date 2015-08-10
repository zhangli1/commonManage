<?php
namespace common\controllers; 

use Yii;
use yii\web\Controller;
use yii\rbac\DbManager;

class DController extends Controller 
{
	public $mainMenus = [];
	public $tmpMenus = [];

	public function init()
	{
		Yii::$app->session->open();

		$mainMenus = Yii::$app->session->get('mainMenus');
		if(isset($mainMenus) && !empty($mainMenus))
		{
			$this->mainMenus = json_decode($mainMenus, true);
			return;
		}		
		$this->mainMenus  = [
			[
                                'label' =>  'Administrator',
                                'url' => ['/admin/index'],
                                'visible' => '',
                                'items' => [
                                        [
                                        'label' => 'admin',
					'url' => ['/admin/index'],
					'customAbstract' => '管理员首页',
                                        'visible' => '' 
                                        ],
                                        [
                                        'label' => 'Role',
                                        'url' => ['/role/index'],
					'customAbstract' => '角色管理首页',
                                        'visible' => '' 
                                        ]
                                ]
			],
			[
				'label' => 'test',
				'url' => ['/test/index'],
				'visible' => '',
				'items' => [
					[
					'label' => 'test1',
					'url' => ['/test1/index'],
					'visible' => ''
					]
				]
			]
		];
		$menus = $this->setVisible($this->mainMenus);
		$this->mainMenus = $menus;
		if(!Yii::$app->user->isGuest)
		{
			Yii::$app->session->set('mainMenus', json_encode($this->mainMenus));
		}
	}


	//递归赋值
	public function setVisible($arr)
	{
		$newArr = [];
		//自动确认是否有权限
		foreach ($arr as $k => $v)
		{
			if (isset($v['label']) && !empty($v['url'][0]))
			{
				$auth = $v['url'][0];
				$v['visible'] = $this->getUserAuth($auth);
				$newArr[$k] = $v;
				if (isset($v['items']) && !empty($v['items']))
				{
					foreach($v['items'] as $vk => $vv)
					{
						$vv['visible'] = $this->getUserAuth($vv['url'][0]);
						$newArr[$k]['items'][$vk] = $vv;
					}
				}
			} 
			//$auth = $v['url'][0];
			//$this->mainMenus['visible'] = $this->getUserAuth();
		}
		return $newArr;
	}


	public function getUserAuth($permission)
	{
		$permissionStr = urlencode($permission);

		$userId = yii::$app->user->id;

		$rbacModel = new DbManager;
		$permissions = array_keys($rbacModel->getPermissionsByUser($userId));
		if (in_array($permissionStr, $permissions))
		{
			return 1;
		}
		return '';
	}
}
