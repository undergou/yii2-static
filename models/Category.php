<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\data\Sort;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property integer $id_parent
 * @property string $slug
 * @property integer $status
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parent', 'status'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'id_parent' => 'Id Parent',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }
    public function getArticles()
    {
         return $this->hasMany(Article::className(), ['category_name' => 'title']);
    }
    public static function getArticlesByCategory($slug)
    {
        $sort = new Sort([
            'attributes' => [
                'date_create',
                'date_updated',
                'title' =>[
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Title',
                ],
            ],
        ]);

        $categoryTitle = Category::find()->where(['slug'=>$slug])->one()->title;

        if(Yii::$app->user->isGuest){
            $query = Article::find()->where(['status'=>'guest', 'category_name'=>$categoryTitle])->orderBy($sort->orders);
        } elseif(Yii::$app->user->identity->username == 'admin'){
            $query = Article::find()->where(['category_name'=>$categoryTitle])->orderBy($sort->orders);
        } else{
            $query = Article::find()->where(['status'=>['user','guest'], 'category_name'=>$categoryTitle])->orderBy($sort->orders);
        }

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>3]);
        $pagination->pageSizeParam = false;
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

            $data['articles'] = $articles;
            $data['pagination'] = $pagination;
            $data['sort'] = $sort;

            return $data;
    }
}
