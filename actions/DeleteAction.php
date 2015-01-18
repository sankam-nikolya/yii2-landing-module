<?php

namespace backend\modules\landing\actions;

use yii\base\Action;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;

/**
 * DeleteAction for images and files.
 * 
 */
class DeleteAction extends Action
{
    /**
     * @var string Path to directory where files will be uploaded
     */
    public $path;

    /**
     * @var string URL path to directory where files will be uploaded
     */
    public $url;        


    public function init()
    {
        if ($this->path === null) 
            throw new InvalidConfigException('The "path" attribute must be set.');
        else 
            $this->path = FileHelper::normalizePath(Yii::getAlias($this->path)) . DIRECTORY_SEPARATOR;
        
        if ($this->url === null)
            throw new InvalidConfigException('The "url" attribute must be set.');
    }
    
    public function run()
    {                                
        $this->deleteFile(Yii::$app->request->post('filename'));
    }
    
    private function deleteFile($filename)
    {
        if(empty($filename))
            return false;        
                    
        $file = $this->path . $filename;                
        
        if(@is_file($file))
            @unlink($file);                
    }

}
