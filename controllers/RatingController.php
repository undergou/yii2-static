<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Rating;
use app\models\Article;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use Yii;

class RatingController extends ActiveController
{
    public $modelClass = 'app\models\Rating';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['index'], $actions['delete'], $actions['update'], $actions['view']);
        return $actions;
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $slug = $request->post('slug');
        $rate = $request->post('rate');
        var_dump(Yii::$app->getRequest()->getBodyParams());
        $ip = Yii::$app->request->userIP;
        $article = Article::find()->where(['slug' => $slug])->one();
//        Yii::$app->response->format = Response::FORMAT_JSON;
        $rating = new Rating();
        if(!Rating::validateIp($slug, $ip)){
            $rating->post = $slug;
            $rating->ip = $ip;
            $rating->rate = $rate;
            $rating->save();

//            $query = (new \yii\db\Query())
//                ->select('rate')
//                ->from('rating')
//                ->where(['post' => $slug])
//                ->all();
//            $arrayRates = array();
//            for ($i=0; $i < count($query); $i++) {
//                $val = ArrayHelper::getValue($query, $i);
//                $value = ArrayHelper::getValue($val, 'rate');
//                array_push($arrayRates, $value);
//            }
//            $countRates = count($arrayRates);
            $article->sum += $rate;
            $article->count++;
            $article->save();

            return '<div class="alert alert-success">You have successfully voted! Your vote is '.$rate.'</div>';
        }
        elseif (Rating::validateIp($slug, $ip)) {
            return '<div class="alert alert-danger">You have already voted</div>';
        }
    }
//    public function checkAccess($action, $model = null, $params = [])
//    {
//        return Rating::find()->where(['post'=> $slug, 'ip' => $ip])->all();
//
//    }
}