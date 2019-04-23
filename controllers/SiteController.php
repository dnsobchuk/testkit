<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\db\Query;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        if($user->TimeOver) return $this->redirect(['site/access-deny']);
        if($user->can(User::ACCESS_LEVEL_CRUD_USERS))  return $this->redirect(['admin/index']);
        if($user->can(User::ACCESS_LEVEL_EDIT_TEST))   return $this->redirect(['edit/index']);
        if($user->can(User::ACCESS_LEVEL_FULL_RESULT)) return $this->redirect(['result/index']);
        $session = Yii::$app->session;
        $session->open();
        $finish = false;
        $count = $session['countQuestion'];
        $result = $session['result'];
        if(isset($_SESSION['result'])){
            unset($session['result']);
            $finish = true;
        }
        $session->close();
        $query = Yii::$app->user->identity->getTests();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' =>  $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        $words = ['вопрос', 'вопроса', 'вопросов'];
        return $this->render('index', [
            'pages'           => $pages,
            'models'          => $models,
            'finish'          => $finish,
            'count'           => $count,
            'result'          => $result,
            'words'           => $words
        ]);
    }

    /**
     * @return string
     */
    public function actionAccessDeny(){
        $userName = Yii::$app->user->identity->LOGIN;
        return $this->render('accessDeny', [
           'userName' => $userName
        ]);
    }
}
