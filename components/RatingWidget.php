<?php

namespace app\components;

use yii\base\Widget;

class RatingWidget extends Widget
{
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        return $this->render('rating');
    }
}
