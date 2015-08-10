<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;


?>

<h1>role/add</h1>


<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['layout'=>'horizontal', 'id' => 'login-form']); ?>
                <?= $form->field($model, 'username', ['template' => '{label} <div class="input-group"><span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user" aria-hidden="true" ></span></span>{input}</div>{error}']) ?>
                <?= $form->field($model, 'password', ['template' => '{label} <div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true" ></span></span>{input}</div>{error}'])->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
