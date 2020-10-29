<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <div class="body-content container">
        <?php
        foreach ($products as $product) { ?>
            <div class="pt-2 pb-2" style="width: 50%; float: left">
                <h2 class="pb-1"><?= $product->tittle ?></h2>
                <img src="<?= '../../' . $product->img ?>" alt="image" width="300px">
                <p class="pt-2">Характеристики: <?= $product->subject ?></p>
                <p class="pt-2">Цена <?= $product->price ?> Р.</p>
                <?php
                if (!Yii::$app->user->isGuest) {
                    ?> <?=
                    Html::a('Добавить в корзину',
                        Url::to(['site/add', 'id' => $product->id]),
                        ['data-method' => 'POST', 'class' => 'btn btn-dark mr-1'])
                    ?>
                <?php } ?>
                <span><?= Html::a('Купить в один клик', ['add', ['id' => $product->id]]) ?></span>
            </div>
        <?php } ?>
    </div>
</div>
