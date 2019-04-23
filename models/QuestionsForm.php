<?php

namespace app\models;

use Yii;

class QuestionsForm extends Answer
{
    public $answers = [];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['answers', 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'answers' => 'Выберите вариант(ы) ответа:',
        ];
    }

    /**
     * Записывает в сессию данные из POST
     */
    public function writePost(){
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $session->open();
        $questionsForm = $request->post('QuestionsForm');
        $this->answers = $questionsForm['answers'];
        $sessionData[$session['currentTest']] = $session['TESTS'][$session['currentTest']];
        $sessionData[$session['currentTest']][$request->post('currentQuestion')] = $this->answers;
        $session['TESTS'] = $sessionData;
        $session->close();
    }
}