<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
if(!Yii::$app->user->isGuest):
    if(Yii::$app->user->identity->username == 'admin'):

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author',
            'title',
            'slug',
            'category_name',
            [
                'label' => 'Tags',
                'value' => $tagsString
            ],
            // 'tag',
            'date_create',
            'date_updated',
            'status',
            'content:ntext',
            'short_content:ntext',
            'rating',
        ],
    ]) ?>

</div>
<?php endif;?>
<?php endif;?>
