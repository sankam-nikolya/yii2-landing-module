<?php

namespace backend\modules\landing;

use yii\base\InvalidConfigException;

class Landing extends \yii\base\Module
{
//    public $controllerNamespace = 'backend\modules\landing\controllers';    
    public $imgPath;
    public $imgUrl;

    public function init()
    {
        parent::init();

        if ($this->imgPath === null)
            throw new InvalidConfigException('The "imgPath" attribute must be set.');
        
        if ($this->imgUrl === null)
            throw new InvalidConfigException('The "imgUrl" attribute must be set.');
        
        
    }
}
