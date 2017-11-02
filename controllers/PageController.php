<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use app\models\Article;
use app\models\Category;
use yii\helpers\ArrayHelper;
use app\models\Tag;
use yii\data\Sort;
use app\models\Rating;

class PageController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'date_create',
                'date_updated',
                'rating' => [
                    'asc' => ['rating' => SORT_DESC],
                    'desc' => ['rating' => SORT_ASC],
                ],
                'title' =>[
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Title',
                ],
            ],
        ]);

        $categories = Category::find()->all();
        if(Yii::$app->user->isGuest){
            $query = Article::find()->where(['status'=>'guest'])->orderBy($sort->orders);
        } elseif(Yii::$app->user->identity->username == 'admin'){
            $query = Article::find()->orderBy($sort->orders);
        } else{
            $query = Article::find()->where(['status'=>['user','guest'] ])->orderBy($sort->orders);
        }

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>5]);
        $pagination->pageSizeParam = false;
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index',[
            'articles'=>$articles,
            'pagination'=>$pagination,
            'categories'=>$categories,
            'sort' =>$sort,
        ]);
    }


    public function actionView($slug)
    {
            $article = Article::find()->where(['slug'=>$slug])->one();
            $tags = $article->tags;

            $ip = Yii::$app->request->userIP;
            $articleRating = Rating::getArticleForRating($slug, $ip);
            if($articleRating){
                $userRating = $articleRating->rate;
            } else{
                $userRating = null;
            }

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
                if($countRates){
                    $userRatingAverage = (int) round(array_sum($arrayRates)/$countRates);
                } else {
                    $userRatingAverage = null;
                }

                    return $this->render('single',[
                        'article' => $article,
                        'tags' => $tags,
                        'userRating' => $userRating,
                        'userRatingAverage' => $userRatingAverage
                    ]);
    }


    public function actionCategory($slug)
    {
        $category = Category::find()->where(['slug'=>$slug])->one();
        $data = Category::getArticlesByCategory($slug);

        return $this->render('category',[
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'category' => $category,
            'sort' =>$data['sort'],
        ]);
    }

    public function actionTag($slug)
    {
        $tag = Tag::find()->where(['slug'=>$slug])->one();
        $data = Tag::getArticlesByTag($slug);

        return $this->render('tag', [
            'tag' => $tag,
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'sort' => $data['sort'],
            'slug' => $slug,
        ]);
    }
}
