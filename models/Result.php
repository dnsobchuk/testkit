<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "RESULTS".
 *
 * @property int $ID_RESULT _autoIncremented
 * @property int $FID_USER ВК пользователя
 * @property int $FID_TEST ВК на тесты
 * @property int $RIGHT_ANSWERS Количество правильных ответов
 */
class Result extends ActiveRecord
{
    public $val = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RESULTS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FID_USER', 'FID_TEST'], 'required'],
            [['ID_RESULT', 'FID_USER', 'FID_TEST', 'RIGHT_ANSWERS'], 'integer'],
            [['ID_RESULT'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_RESULT' => 'ID результата',
            'FID_USER' => 'Fid  User',
            'FID_TEST' => 'Fid  Test',
            'RIGHT_ANSWERS' => 'Правильные ответы',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::class, ['ID_TEST' => 'FID_TEST']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['ID_USER' => 'FID_USER']);
    }

    /**
     *
     */
    public function resultInit(){
        $session = Yii::$app->session;
        $session->open();
        $this->FID_TEST = $session['currentTest'];
        $this->FID_USER = intval($session['currentUserId']);
        $this->setCountRightAnswers($session['TESTS'][$this->FID_TEST]);
        $session['result'] = $this->RIGHT_ANSWERS;
        $session->close();
    }

    /**
     * @param $data
     */
    public function setCountRightAnswers($data)
    {
        $countRightAnswers = 0;
        foreach ($data as $questId => $answersId){
            $question = Question::findOne($questId);
            $countUserAnswers = $question->getAnswers()->where(['ID_ANSWER' => $answersId,'IS_RIGHT' => 1])->count();
            $countTrueAnswers = $question->getAnswers()->where(['IS_RIGHT' => 1])->count();
            (count($answersId) == $countUserAnswers) && ($countUserAnswers == $countTrueAnswers) ?
                $countRightAnswers++ : null;
        }
        $this->RIGHT_ANSWERS = $countRightAnswers;
    }

    /**
     * @param Question $question
     * @param $answerData
     * @return bool
     */
    public function getRightQuestion(Question $question, $answerData)
    {
        $countUserAnswers = $question->getAnswers()->where(['ID_ANSWER' => $answerData,'IS_RIGHT' => 1])->count();
        $countTrueAnswers = count($answerData);
        return (count($answerData) == $countUserAnswers)  && ($countTrueAnswers == $countUserAnswers);
    }

    /**
     * @return bool
     */
    public function saveResult()
    {
        $session = Yii::$app->session;
        $session->open();
        $answerData = $session['TESTS'][$this->FID_TEST];
        $session->close();
        return $this->save() && $this->saveUserAnswer($answerData, $this->ID_RESULT);
    }

    /**
     * @param $answers
     * @param $idResult
     * @return bool
     */
    private function saveUserAnswer($answers, $idResult)
    {
        foreach ($answers as $item => $value) {
            if (!empty($value)) {
                foreach ($value as $answer){
                    $userAnswer = new UserAnswer();
                    $userAnswer->FID_RESULTS = $idResult;
                    $userAnswer->FID_RESULT_QUESTIONS = $item;
                    $userAnswer->FID_RESULT_ANSWERS = $answer;
                    if (!$userAnswer->save()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}
