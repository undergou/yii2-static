<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Article */
if(!Yii::$app->user->isGuest):
    if(Yii::$app->user->identity->username == 'admin'):

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'tags' => $tags,
        'status' => $status,
    ]) ?>

</div>
<?php endif;?>
<?php endif;?>
