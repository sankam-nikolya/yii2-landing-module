<?php

namespace backend\modules\landing\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\landing\LandingAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;


class DefaultController extends Controller
{    
    public function init() {
        parent::init();
        LandingAsset::register($this->view);
    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return [
            'imageUpload' => [
                'class' => 'backend\modules\landing\actions\UploadAction',
                'url' => Yii::$app->getModule('landing')->imgUrl, // Directory URL address, where files are stored.
                'path' => Yii::$app->getModule('landing')->imgPath // Or absolute path to directory where files are stored.
            ],
            'imageDelete' => [
                'class' => 'backend\modules\landing\actions\DeleteAction',
                'url' => Yii::$app->getModule('landing')->imgUrl, // Directory URL address, where files are stored.
                'path' => Yii::$app->getModule('landing')->imgPath // Or absolute path to directory where files are stored.
            ],
            'imageListImages' => [
                'class' => 'backend\modules\landing\actions\ListImagesAction',
                'url' => Yii::$app->getModule('landing')->imgUrl, // Directory URL address, where files are stored.
                'path' => Yii::$app->getModule('landing')->imgPath // Or absolute path to directory where files are stored.
            ]
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionCreate()
    {   
        
        $uploadAction = Url::to(["default/imageUpload"]);
        $deleteAction = Url::to(["default/imageDelete"]);
        $listImagesAction = Url::to(["default/imageListImages"]);
        $setting = [
            'imageUpload'=>$uploadAction,
            'imageDelete'=>$deleteAction,
            'listImagesAction'=>$listImagesAction
        ];                
//        $setting['uploadImageFields'][Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
//        $setting['uploadFileFields'][Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
        
        $settings = Json::encode($setting);
        
        $this->view->registerJs("runLanding($settings);");
        
        return $this->render('create');
    }
    
    public function actionImageUpload()
    {
        
    }
}
