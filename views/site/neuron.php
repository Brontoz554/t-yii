<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Neuron */
/* @var $form ActiveForm */
?>
<div class="site-neuron">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'amount') ?>
        <?= $form->field($model, 'name_on_card') ?>
        <?= $form->field($model, 'cart_number') ?>
        <?= $form->field($model, 'expries') ?>
        <?= $form->field($model, 'security code') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-neuron -->
