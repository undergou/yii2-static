<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
 ?>
 <div class="content-body">
     <h1>Tag: <?= $tag->title; ?></h1>
     <br>
     <?php foreach ($articles as $article): ?>
         <h4><a href="<?= Url::toRoute(['/page/category', 'slug'=>$article->category->slug]); ?>"><?= $article->category->title; ?></a></h4>
         <h2><a href="<?= Url::toRoute(['/page/view', 'slug'=>$article->slug]); ?>"><?= $article->title; ?></a></h2>
         <p><?= $article->short_content; ?></p>
         <p><?= $article->date_create; ?></p>
         <hr>
     <?php endforeach; ?>
 <?php
         echo LinkPager::widget([
         'pagination' => $pagination,
     ]);
 ?>
