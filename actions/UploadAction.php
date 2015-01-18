<?php

namespace backend\modules\landing\actions;

use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;

/**
 * UploadAction for images and files.
 * 
 */
class UploadAction extends Action
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
     * @var string Validator name
     */
    public $uploadOnlyImage = true;

    /**
     * @var string Variable's name that Imperavi Redactor sent upon image/file upload.
     */
    public $uploadParam = 'file';

    /**
     * @var boolean If `true` unique filename will be generated automatically
     */
    public $unique = true;

    /**
     * @var array Model validator options
     */
    public $validatorOptions = [];

    /**
     * @var string Model validator name
     */
    private $_validator = 'image';

    /**
     * @inheritdoc
     */
    public function init()
    {
//        if ($this->url === null) {
//            throw new InvalidConfigException('The "url" attribute must be set.');
//        } else {
//            $this->url = rtrim($this->url, '/') . '/';
//        }
        
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
//        if ($this->uploadOnlyImage !== true) {
//            $this->_validator = 'file';
//        }        
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
                
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName($this->uploadParam);
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', $this->_validator, $this->validatorOptions)->validate();

//            print_r($file);
//            return;
            
            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file')
                ];
            } else {
                if ($this->unique === true && $model->file->extension) {
                    $model->file->name = uniqid() . '.' . $model->file->extension;
                }
                if ($model->file->saveAs($this->path . $model->file->name)) {
                    $result = [
                        'filelink' => $this->url . $model->file->name,                        
                        'filename'=>$model->file->name
                    ];
//                    if ($this->uploadOnlyImage !== true) {
//                        $result['filename'] = $model->file->name;
//                    }
                } else {
                    $result = [
                        'error' => Yii::t('imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')
                    ];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }
}
