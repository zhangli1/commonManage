<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form ActiveForm */
$this->title = 'Sign In';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sign-in">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please sign in :</p>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password_hash')->passwordInput() ?>
        <?= $form->field($model, 'email') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- sign-in -->
