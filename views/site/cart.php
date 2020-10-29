<?php

/* @var $this yii\web\View */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
$total_price = 0;

foreach ($products as $product) {
    /** @var $total_price */
    $total_price += $product->product->price;
    ?>
    <div class="pt-2 pb-2" style="width: 50%; float: left">
        <p><?= $product->product->tittle ?></p>
        <img src="<?= '../../' . $product->product->img ?>" alt="image" width="80%">
        <p>Характеристики: <?= $product->product->subject ?></p>
        <p>Цена <?= $product->product->price ?> Р.</p>
        <?=
        Html::a('Убрать из корзины',
            Url::to(['site/delete', 'id' => $product->id]),
            ['data-method' => 'POST', 'class' => 'btn btn-danger mr-1'])
        ?>
    </div>
<?php } ?>
<div class="price w-100">
    <div class="total">
        <p>Общая сумма <?= $total_price ?> Р.</p>
        <?php
        Modal::begin([
            'header' => '<h2>Оплата Neuron</h2>',
            'toggleButton' => ['label' => 'Оформить заказ', 'class' => 'btn btn-dark'],
        ]); ?>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name_on_card')->textInput() ?>
        <?= $form->field($model, 'cart_number') ?>
        <?= $form->field($model, 'expries')?>
        <?= $form->field($model, 'security_code')?>

        <div class="form-group">
            <?= Html::submitButton('Оплатить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php
            ActiveForm::end();
            Modal::end();
        ?>
    </div>
</div>