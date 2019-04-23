<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "USER_ANSWERS".
 *
 * @property int $FID_RESULTS ВК на полученные результаты
 * @property int $FID_RESULT_QUESTIONS ВК на пройденный вопрос
 * @property int $FID_RESULT_ANSWERS ВК на данный ответ
 */
class UserAnswer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'USER_ANSWERS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FID_RESULTS', 'FID_RESULT_QUESTIONS', 'FID_RESULT_ANSWERS'], 'required'],
            [['FID_RESULTS', 'FID_RESULT_QUESTIONS', 'FID_RESULT_ANSWERS'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FID_RESULTS' => 'Fid  Results',
            'FID_RESULT_QUESTIONS' => 'Fid  Result  Questions',
            'FID_RESULT_ANSWERS' => 'Fid  Result  Answers',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getResults()
    {
        return $this->hasMany(Result::class, ['ID_RESULT' => 'FID_RESULTS']);
    }

    /**
     * @param Result $result
     * @return array
     */
    public static function getTestData(Result $result) {
        $dataTest = [];
        $test = $result->test;
        /** @var Test $test */
        $testQuestions = $test->getQuestions()->all();
        foreach ($testQuestions as $question){
            /** @var Question $question */
            $dataTest[$question->ID_QUESTION] = Answer::findAll(['FID_QUESTION' => $question->ID_QUESTION]);
        }
        return $dataTest;
    }

    /**
     * @param Result $result
     * @return array
     */
    public static function getUserData(Result $result) {
        $userData = [];
        $userAnswers = self::findAll(['FID_RESULTS' => $result->ID_RESULT]);
        sort($userAnswers);
        foreach ($userAnswers as $userAnswer){
            $answers = Answer::findAll(['ID_ANSWER' => $userAnswer->FID_RESULT_ANSWERS]);
            foreach ($answers as $answer){
                $userData[$answer->FID_QUESTION][] = $answer->ID_ANSWER;
            }
        }
        return $userData;
    }
}
