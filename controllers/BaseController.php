<?php

namespace app\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    protected $accessLevel = null;

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest){
            $this->redirect(['auth/login']);
            return false;
        }
        if($this->accessLevel !== null && !Yii::$app->user->identity->can($this->accessLevel)){
            $this->redirect(['site/index']);
            return false;
        }
        return parent::beforeAction($action);
    }

}
