<?php
use yii\helpers\Html;
use yii\web\HttpException;
?>

<div id="wrapper" onclick="show('none');"></div>

<?= $this->render('single', [
    'rate' => $rate,
    'article' => $article,
    'tags' => $tags,
    'userRating' => $userRating,
    'userRatingAverage' => $userRatingAverage
    ])?>


    <div id="window">
        <h2 style="color: red">You have already voted!</h2>
    </div>
