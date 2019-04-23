<?php

namespace app\controllers;

use app\models\Answer;
use app\models\Question;
use app\models\QuestionsForm;
use app\models\Result;
use app\models\Test;
use Yii;
use yii\helpers\Html;
use yii\web\Response;


class TestController extends BaseController
{
    public $layout = 'test';

    /**
     * @return Response
     * Инициализирует тест
     * При успешной инициализации переводит на страницу прохождения теста
     */
    public function actionIndex(){

        $session = Yii::$app->session;
        $session->open();
        if (!$session['currentTest'] && isset($_GET['testId'])) {
            if(!Test::testDone($_GET['testId'])) return $this->redirect(['site/access-deny']);
            Test::testInit($_GET['testId']);
        } elseif(!$session['currentTest'] && !$_GET['testId']) $this->redirect('index');
        return $this->redirect('progress');
    }

    /**
     * Проверяется прохождение теста
     * @return string|Response
     */
    public function actionProgress(){

        $session = Yii::$app->session;
        $session->open();
        $findEmpty = function ($item) {
            return $item == null;
        };
        $rand = array_filter($session['TESTS'][$session['currentTest']], $findEmpty);
        $found = $rand ? array_rand($rand) : false;
        $session['found'] = $found;
        if ($session['endTime'] <= time() || (!$session['found']) && !empty($session['TESTS'][$session['currentTest']]))
        {
            return $this->redirect('finish');
        }
        $session->close();
        return $this->redirect('update');
    }

    /**
     * Обновление данных теста
     * @return string
     *
     */
    public function actionUpdate(){
        $session = Yii::$app->session;
        $session->open();
        $currentTest = Test::findOne($session['currentTest']);
        $currentTest->TITLE_TEST = Html::decode($currentTest->TITLE_TEST);
        $currentQuestion = $session['found'] ? Question::findOne($session['found']) : $currentTest->getFirstQuestion();
        $currentQuestion->CONTENT_QUESTION = Html::decode($currentQuestion->CONTENT_QUESTION);
        $currentAnswers = $currentQuestion->getAnswers()->orderBy('ID_ANSWER')->all();
        /** @var Answer $answer */
        foreach ($currentAnswers as $answer){
            $answer->CONTENT_ANSWER = Html::decode($answer->CONTENT_ANSWER);
        }
        shuffle($currentAnswers);
        $countQuestion = $session['countQuestion'];
        $currentQuestionNumber = count(array_filter($session['TESTS'][$currentTest->ID_TEST]));
        $session->close();
        $finish = $currentQuestionNumber == $currentTest->getQuestions()->count();
        return $this->render('index', [
            'currentTest'           => $currentTest,
            'currentQuestion'       => $currentQuestion,
            'currentAnswers'        => $currentAnswers,
            'dataTime'              => $currentTest->timeProgress(),
            'countQuestion'         => $countQuestion,
            'currentQuestionNumber' => $currentQuestionNumber,
            'finish'                => $finish,
            'questionForm'          => new QuestionsForm()
        ]);
    }

    /**
    * Сохранение в сессии вопроса и ответов на него
     * @return Response
     */
    public function actionPost(){
        $questionForm = new QuestionsForm();
        $questionForm->writePost();
        return $this->redirect('progress');
    }

    /**
     * @return Response
     * Завершение теста
     * Сохраняет результы и возвращает на index
     * Если не удалось сохранить переводит на страницу ошибок
     */
    public function actionFinish(){
        $result = new Result();
        $result->resultInit();
        if($result->saveResult()){
            $session = Yii::$app->session;
            $session->open();
            unset($session['currentTest']);
            $session->close();
            return $this->redirect(['site/index']);
        }
        return $this->redirect(['site/error']);
    }

}