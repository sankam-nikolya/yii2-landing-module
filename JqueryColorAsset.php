<?php

/**
 * JqueryColorAsset
 *
 * @author JohnBo
 */

namespace backend\modules\landing;

use yii\web\AssetBundle;

class JqueryColorAsset extends AssetBundle 
{
    
    /**
    * @inheritdoc
    */
    public $sourcePath = '@bower/jquery-color';        
    
    /**
    * @inheritdoc
    */
    public $js = [
        'jquery.color.js',
    ];
    
    /**
    * @inheritdoc
    */
    public $depends = [
        'yii\web\JqueryAsset'        
    ];
}
