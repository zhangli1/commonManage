<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;

?>
<h1>role/update</h1>


<!-- 添加权限 -->
<?= Html::a('添加', false, ['class' => 'btn btn-success ', 'id'=>'addItem', 'style'=>'float:right;margin:5px;']) ?>

<div id="addItemper" style="display:none;background-color:#F9F9F9;text-align:center;margin-left:20%;margin-top:5%;padding:20px;width:30%;border:1px solid gray;z-index:999;position:fixed;"></div>
<?= 
$space = '';
$item_name = Yii::$app->request->get('item_name');
$script = <<< JS
$('#addItem').on('click', function(e) {
    $.ajax({
       type: 'get',
       url: 'index.php?r=role/create',
       data: {item_name: "$item_name"},
       success: function(data) {
		var items = eval('(' + data + ')');
		if(items.length>0){
			$('#addItemper').show();
		}
		for(i in items){
			$('#addItemper').append('<input label-name="' + items[i]  + '" style="margin:10px;" name="item" type="checkbox" ><label>' + items[i] + '</label>');
		}
		$('#addItemper').append('<br/><button style="margin-top:1%;" id="itmem-sub">submit</button>');
		$('#itmem-sub').click(function(){
			var itemarr = [];
			$('#addItemper input:checked').each(function(i){
				itemarr.push($(this).attr('label-name'));
			})
			
			$.ajax({
			        type: 'get',
				url: 'index.php?r=role/add-item',
				data: {item_name: "$item_name", items: itemarr.join(',')},
				success: function(data) {
					$('#addItemper').html('');
					$('#addItemper').hide();
					location.href = '';
				}, 
				error: function(msg){alert(msg.error)}
			});
		})
           // process data
       }
    });
});
JS;
$this->registerJs($script);
?>




<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'description',
          [
		'class' => 'yii\grid\ActionColumn',
		'header'=>'Edit',
		'template'=>'{delete}',
	],
    ],
]) ?>

