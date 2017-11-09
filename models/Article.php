<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $author
 * @property string $title
 * @property string $slug
 * @property string $category_name
 * @property string $tag
 * @property string $date_create
 * @property string $date_updated
 * @property integer $status
 * @property string $content
 * @property string $short_content
 * @property integer $rating
 *
 * @property ArticleTag[] $articleTags
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author', 'slug', 'category_name', 'content'], 'required'],
            [['date_create', 'date_updated'], 'date', 'format'=>'php:Y-m-d'],
            [['date_create'], 'default', 'value'=> date('Y-m-d')],
            [['date_updated'], 'default', 'value'=> date('Y-m-d')],
            [['date_create', 'date_updated'], 'safe'],
            // [['rating'], 'integer'],
            [['content', 'short_content', 'status'], 'string'],
            [['author', 'title', 'slug'], 'string', 'max' => 255],
            [['sum', 'count'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
                'timestamp' => [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'date_create',
                    'updatedAtAttribute' => 'date_updated',
                    'value' => new Expression('NOW()'),
                ],

    ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'title' => 'Title',
            'slug' => 'Slug',
            'category_name' => 'Category',
            'tag' => 'Tag',
            'date_create' => 'Date Create',
            'date_updated' => 'Date Updated',
            'status' => 'Status',
            'content' => 'Content',
            'short_content' => 'Short Content',
            'rating' => 'Rating',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['title' => 'category_name']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveTags($tags)
    {
        if(is_Array($tags))
        {
            $this->clearCurrentTags();

            foreach ($tags as $tag_title)
            {
                $tag = Tag::find()->where(['title' => $tag_title])->one();
                $this->link('tags', $tag);
            }
        }
    }
    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' =>$this->id]);
    }
    public function getSlug()
    {
        return $this->slug;
    }
    public function getStatus()
    {
        return [
            ['id'=>'1', 'status' =>'guest'],
            ['id'=>'2', 'status' =>'user'],
            ['id'=>'3', 'status' =>'admin'],
        ];
    }

}
