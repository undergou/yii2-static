<?php

namespace app\models;
use Yii;

class Rating extends \yii\db\ActiveRecord
{
    public function rules()
    {
          return [
              [['rate'], 'required'],
              [['post', 'ip'], 'string'],
              [['rate'], 'integer'],
          ];
    }

    public static function tableName()
    {
        return 'rating';
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post' => 'Post',
            'rate' => 'Rate',
            'ip' => 'IP',
        ];
    }
    public function validateIp($slug, $ip)
    {
            return Rating::find()->where(['post'=> $slug, 'ip' => $ip])->all();
    }
    public function getArticleForRating($slug, $ip)
    {
        return Rating::find()->where(['post'=> $slug, 'ip' => $ip])->one();
    }


}
