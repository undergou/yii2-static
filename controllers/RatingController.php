<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Rating;
use app\models\Article;
use yii\helpers\ArrayHelper;
use Yii;

class RatingController extends ActiveController
{
    public $modelClass = 'app\models\Rating';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $slug = $request->post('slug');
        $rate = $request->post('rate');
        $ip = Yii::$app->request->userIP;
        $article = Article::find()->where(['slug' => $slug])->one();

        $rating = new Rating();
        if(!Rating::validateIp($slug, $ip)){
            $rating->post = $slug;
            $rating->ip = $ip;
            $rating->rate = $rate;
            $rating->save();

            $query = (new \yii\db\Query())
                ->select('rate')
                ->from('rating')
                ->where(['post' => $slug])
                ->all();
            $arrayRates = array();
            for ($i=0; $i < count($query); $i++) {
                $val = ArrayHelper::getValue($query, $i);
                $value = ArrayHelper::getValue($val, 'rate');
                array_push($arrayRates, $value);
            }
            $countRates = count($arrayRates);
            $article->rating = array_sum($arrayRates)/$countRates;
            $article->save();

            return '<div class="alert alert-success">You have successfully voted! Your vote is '.$rate.'</div>';
        }
        elseif (Rating::validateIp($slug, $ip)) {
            return '<div class="alert alert-danger">You have already voted</div>';
        }
    }
}