<?php

/**
 * Description of LandingAsset
 *
 * @author andrew
 */

namespace backend\modules\landing;

use yii\web\AssetBundle;

class LandingAsset extends AssetBundle 
{
    
    /**
    * @inheritdoc
    */
    public $sourcePath = '@backend/modules/landing/assets';
    
    /**
    * @inheritdoc
    */
    public $css = [
        'css/landing.css',
    ];
    
    /**
    * @inheritdoc
    */
    public $js = [
        'js/landing.js',
    ];
    
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    
    /**
    * @inheritdoc
    */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'backend\modules\landing\ImperaviYiiAsset',
        'backend\modules\landing\JqueryColorAsset'
//        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
