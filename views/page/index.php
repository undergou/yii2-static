<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;


/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">


    <div class="content-body">
        <h1>New web-site</h1>
        <p>Sort by:</p>
        <p><?= $sort->link('title').' | '. $sort->link('rating'). ' | ' . $sort->link('date_create') . ' | ' . $sort->link('date_updated'); ?></p>
        <br>
        <?php foreach ($articles as $article): ?>
            <h4><a href="<?= Url::toRoute(['/page/category', 'slug'=>$article->category->slug]); ?>"><?= $article->category->title; ?></a></h4>
            <h2><a href="<?= Url::toRoute(['/page/view', 'slug'=>$article->slug]); ?>"><?= $article->title; ?></a></h2>
            <p><?= $article->short_content; ?></p>
            <p>Date create: <?= $article->date_create; ?></p>
            <p>Date updated: <?= $article->date_updated; ?></p>
            <hr>
        <?php endforeach; ?>
<?php
            echo LinkPager::widget([
            'pagination' => $pagination,
        ]);
 ?>
    <div class="categories">
        <h4>Categories</h4>
        <ul>
            <?php foreach($categories as $category):?>
                <li>
                    <a href="<?= Url::toRoute(['/page/category', 'slug'=>$category->slug]); ?>"><?= $category->title ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>
</div>
