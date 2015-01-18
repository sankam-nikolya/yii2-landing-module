<?php

namespace backend\modules\landing\actions;

use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;

/**
 * UploadAction for images and files.
 * 
 */
class ListImagesAction extends Action
{
    /**
     * @var string Path to directory where files will be uploaded
     */
    public $path;

    /**
     * @var string URL path to directory where files will be uploaded
     */
    public $url;
    

    /**
     * @inheritdoc
     */
    public function init()
    {        
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" attribute must be set.');
        } else {
            $this->path = FileHelper::normalizePath(Yii::getAlias($this->path)) . DIRECTORY_SEPARATOR;
            
            if (!FileHelper::createDirectory($this->path)) {
                throw new InvalidCallException("Directory specified in 'path' attribute doesn't exist or cannot be created.");
            }
        }
        
        if ($this->url === null)
            throw new InvalidConfigException('The "url" attribute must be set.');
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $images = array();
        $images= scandir($this->path);                
        
        $jsonArray=array();
        foreach($images as $image)
         {
           if($image!="." && $image!=".." && !is_dir($image))
               $jsonArray[] = [
                          'thumb'=>  $this->url.$image,
                          'image'=>  $this->url.$image,
                ];
        }
        header('Content-type: application/json');
        echo Json::encode($jsonArray);
    }
}
