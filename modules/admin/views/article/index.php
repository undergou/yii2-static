<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!Yii::$app->user->isGuest):
    if(Yii::$app->user->identity->username == 'admin'):
$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author',
            'title',
            'slug',
            'category_name',
            'tag',
            // 'date_create',
            // 'date_updated',
            'status',
            // 'content:ntext',
            // 'short_content:ntext',
            // 'rating',
            // 'category_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);

    ?>
</div>
<?php endif;?>
<?php endif;?>
