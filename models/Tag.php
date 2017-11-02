<?php

namespace app\models;
use yii\data\Pagination;
use yii\data\Sort;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 *
 * @property ArticleTag[] $articleTags
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'slug' => 'Slug',
        ];
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable('article_tag', ['tag_id' => 'id']);
    }
    public function getArticlesByTag($slug)
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

        $tag = Tag::find()->where(['slug'=>$slug])->one();

        if(Yii::$app->user->isGuest){
            $query = $tag->getArticles()->where(['status'=>'guest'])->orderBy($sort->orders);
        } elseif(Yii::$app->user->identity->username == 'admin'){
            $query = $tag->getArticles()->orderBy($sort->orders);
        } else{
            $query = $tag->getArticles()->where(['status'=>['user','guest']])->orderBy($sort->orders);
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
