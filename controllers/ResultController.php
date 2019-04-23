<?php

namespace app\controllers;


use app\models\Result;
use app\models\ResultSearch;
use app\models\Test;
use app\models\User;
use app\models\UserAnswer;
use Yii;
use yii\data\Pagination;

class ResultController extends BaseController
{
    protected $accessLevel = User::ACCESS_LEVEL_FULL_RESULT;

    /**
     * Displays all Result model.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $searchModel = new ResultSearch();
        if($request->post('ResultSearch')) {
            $searchModel->setResult($request->post('ResultSearch'));
        }
        $query = $searchModel->search(Yii::$app->request->queryParams);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'models'     => $models,
            'pages'      => $pages,
            'countQuery' => $countQuery,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Result model.
     * @param integer $id
     * @return mixed
     */
    public function actionResult($id)
    {
        $result = Result::findOne($id);
        $user = $result->user;
        /** @var Test $test */
        $test = $result->test;
        $count = $test->getCountQuestions();
        $dataTest = UserAnswer::getTestData($result);
        $answerData = UserAnswer::getUserData($result);
        return $this->render('result', [
            'result'       => $result,
            'user'         => $user,
            'dataTest'     => $dataTest,
            'answerData'   => $answerData,
            'count'        => $count
        ]);
    }
}