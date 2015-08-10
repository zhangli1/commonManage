<?php
namespace console\controllers; 
 
use Yii;
use yii\console\controllers;
 
class MyrbacController extends \yii\console\Controller 
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
 
        // 修改管理员权限
        $updateAdmin = $auth->createPermission('updateAdmin');
        $updateAdmin->description = 'Update Admin auth';
        $auth->add($updateAdmin);
 
	//删除管理员
        $deleteAdmin = $auth->createPermission('deleteAdmin');
        $deleteAdmin->description = 'Delete Admin';
        $auth->add($deleteAdmin);
 
        // add "author" role and give this role the "createPost" permission
        //创建一个“作者”角色，并给它“创建文章”的权限
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $updateAdmin);
 
        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        // 添加“admin”角色，给它“更新文章”的权限
        // “作者”角色
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $deleteAdmin);
        $auth->addChild($admin, $author);

	//普通用户 
        $ordinary = $auth->createRole('ordinary');
        $auth->add($ordinary);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        // 给用户指定角色，1和2是IdentityInterface::getId()返回的ID，就是用户ID。
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
        $auth->assign($ordinary, 34);
    }
}
