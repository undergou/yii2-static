<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Rating;
use app\models\Article;
use yii\helpers\ArrayHelper;

class AjaxController extends Controller
{
    public function actionRequest()
    {
        $request = Yii::$app->request;
        $slug = $request->get('slug');
        $rate = $request->get('rate');
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

            echo '<div class="alert alert-success">You have successfully voted! Your vote is '.$rate.'</div>';
        } elseif (Rating::validateIp($slug, $ip)) {
            echo '<div class="alert alert-danger">You have already voted</div>';
        }
    }
}
