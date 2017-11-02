<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Article;
use app\models\Rating;
use app\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


class RatingController extends Controller
{

    // public function actionIndex()
    // {
    //     $searchModel = new ArticleSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     $dataProvider->pagination->pageSize = 10;
    //
    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }


    public function actionRating()
    {
        $model = new Rating();
        // if(Yii::$app->request->post())
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            return $this->render('rating-show', [
                'model' => $model,
            ]);
        } else {
            return $this->render('rating', [
                'model' => $model,
            ]);
        }

    }
}
