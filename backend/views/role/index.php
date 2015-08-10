<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
?>

<h1>role/index</h1>

<?php
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'role',
        'name',
          [
		'label'=>'更多操作',
                'format'=>'raw',
                'value' => function($data){
                    $url = \Yii::$app->urlManager->createUrl(["role/update", 'item_name'=>$data['role']]);
                    return Html::a('修改权限', $url, ['title' => '更新权限']); 
                }
	],
    ],
]) ?>

