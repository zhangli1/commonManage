<?php

namespace backend\models;

use Yii;
use yii\rbac;
use yii\rbac\DbManager;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{
	const ROLE = 'ordinary';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['role', 'username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => '角色',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /*
     * 查找所有的管理员
     *
     */

    public function getAllAdmin()
   {

		//return User::find()->where('role=1')->all();
		return $dataProvider = new ActiveDataProvider([
			'query' => User::find(),
			'pagination' => [
			'pageSize' => 20,
			],
		]);
   }


    //get user id
    public function getId($username)
    {
		return User::findOne(['username' => $username])['id']; 
    }

    public function signIn()
    {
		$this->auth_key = "1";
		$this->created_at = 2;
		$this->updated_at = 3;
		$count = User::find()->where(['username' => $this->username])->count();
		if ( $count > 0 )
		{
			$this->addError('username', 'username repeat');
			return false;
		}
		$this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);	
		$this->role = self::ROLE;
		$this->save();
		
		
		 //下面三行是新加的
		$auth = Yii::$app->authManager;
		$authorRole = $auth->getRole($this->role);
		$auth->assign($authorRole, $this->getId($this->username));
		

		return true;
    }

	public function saves()
	{
		//修改角色
		$res = Yii::$app->db->createCommand(
				'update auth_assignment set item_name = :item_name, created_at = :at where user_id = :user_id', 
				[':item_name' => $this->role, ':at' => time(), ':user_id' => $this->id])->execute();	
		if($res)
		{
			return parent::save();
		}
		return false;
	}

	//获取所有的角色
	public function getAllroles()
	{

		$rbacModel = new DbManager;
		$keys = array_keys($rbacModel->getRoles());
		$rolesParam = yii::$app->params['rolesByCn'];
		foreach($keys as  $v)
		{
			if(!isset($rolesParam[$v])) 
			{
				$roles[$v] = '未知角色';
			}
			else
			{
				$roles[$v] = $rolesParam[$v];
			}
		}
		return $roles;
	}


	public function getAllRolesData()
	{
		$roles = $this->getAllroles();
		foreach($roles as $k => $v){
			$arr[] = ['role' => $k, 'name' => $v];
		}

		return $provider = new ArrayDataProvider([
			'allModels' => $arr,
			'sort' => [
				'attributes'=> ['role', 'name'],
			],
			'pagination' => ['pageSize' => 10]
			]);
		}

}

# vim: set noexpandtab ts=4 sts=4 sw=4 :
