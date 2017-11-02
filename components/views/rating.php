<?php
use yii\widgets\Pjax;
use yii\helpers\Html;

Pjax::begin(); ?>
    <div class="rating">
        <?= Html::tag("span", "☆", ['id' => 'rate5']) ?>
        <?= Html::tag("span", "☆", ['id' => 'rate4']) ?>
        <?= Html::tag("span", "☆", ['id' => 'rate3']) ?>
        <?= Html::tag("span", "☆", ['id' => 'rate2']) ?>
        <?= Html::tag("span", "☆", ['id' => 'rate1']) ?>
        </div>
    <?php Pjax::end(); ?>



<!-- <div class="rating">
    <span>☆</span>
    <span>☆</span>
    <span>☆</span>
    <span>☆</span>
    <span>☆</span>
</div>  -->
