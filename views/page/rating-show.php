<?php
use yii\helpers\Html;
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
    <h2>You have successfully voted!</h2>
    <p>Your vote:</p>
    <h3><?= Html::encode($rate->rate) ?></h3>
</div>
