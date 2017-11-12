<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Rating;
use app\models\Article;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use Yii;

class RatingController extends ActiveController
{
    public $modelClass = 'app\models\Rating';

    public function checkAccess($action, $model = null, $params = [])
    {
        $ip = Yii::$app->request->userIP;
        if ($action === 'create'){
            if (Rating::find()->where(['ip' => $ip])->all()){
                throw new \yii\web\ForbiddenHttpException('Forbidden Access');
            }
        }
    }

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
        $ip = Yii::$app->request->userIP;
        $article = Article::find()->where(['slug' => $slug])->one();
        $rating = new Rating();

        if(!Rating::validateIp($slug, $ip)){
            $rating->post = $slug;
            $rating->ip = $ip;
            $rating->rate = $rate;
            $rating->save();
            Yii::$app->db->createCommand('UPDATE article SET sum = sum + '.$rate.', count = count + 1 WHERE slug = "'.$slug.'"')->execute();
            $arr = ['message' => 'You have successfully voted', 'classStyle' =>'alert-success'];
            return json_encode($arr);
        }
        elseif (Rating::validateIp($slug, $ip)) {
            $arr = ['message' => 'You have already voted', 'classStyle' =>'alert-danger'];
            return json_encode($arr);
        }
    }

}