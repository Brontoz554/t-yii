<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form ActiveForm */
?>
<div class="site-addProduct">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tittle') ?>
    <?= $form->field($model, 'subject') ?>
    <?= $form->field($model, 'price') ?>
    <?= $form->field($model, 'img')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- site-addProduct -->
