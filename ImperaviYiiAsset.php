<?php

/**
 * ImperaviYiiAsset
 *
 * @author JohnBo
 */

namespace backend\modules\landing;

use yii\web\AssetBundle;

class ImperaviYiiAsset extends AssetBundle 
{
    
    /**
    * @inheritdoc
    */
    public $sourcePath = '@yiiext/imperavi-redactor-widget';        
    
    /**
    * @inheritdoc
    */
    public $js = [
        'assets/redactor.min.js',
        'assets/plugins/imagemanager/imagemanager.js',
    ];
    
    /**
    * @inheritdoc
    */
    public $css = [
        'assets/redactor.css',
    ];
    
    /**
    * @inheritdoc
    */
    public $depends = [
        'yii\web\JqueryAsset'        
    ];
}
