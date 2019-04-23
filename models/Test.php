<?php

namespace app\models;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;


/**
 * This is the model class for table "TESTS".
 *
 * @property int $ID_TEST _autoIncremented
 * @property string $TITLE_TEST
 */
class Test extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TESTS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TITLE_TEST'], 'required'],
            [['TITLE_TEST'], 'unique'],
            [['TITLE_TEST'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_TEST' => 'ID теста',
            'TITLE_TEST' => 'Название теста',
            'CountQuestions' => 'Количество вопросов',
        ];
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getUser()
    {
        return $this->hasMany(User::class, ['ID_USER' => 'FID_USER'])
            ->viaTable('USER_TESTS', ['FID_TEST' => 'ID_TEST']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['FID_TEST' => 'ID_TEST']);
    }

    /**
     * @return int|string
     */
    public function getCountQuestions(){
        return  $this->getQuestions()->count();
    }

    /**
     * @return array|ActiveRecord|null
     */
    public function getFirstQuestion()
    {
        return $this->getQuestions()->orderBy('ID_QUESTION')->one();
    }

    /**
     * @param $testId
     */
    public static function testInit($testId)
    {
        $session = Yii::$app->session;
        $session->open();
        $session['TESTS'] = [];
        $session['currentUserId'] = Yii::$app->user->identity->ID_USER;
        $session['currentTest'] = $testId;
        /** @var Test $currentTest */
        $currentTest = Test::findOne($session['currentTest']);
        $allQuestions = $currentTest->getQuestions()->all();
        $tests = $session['TESTS'];

        foreach ($allQuestions as $quest) {
            $tests[$currentTest->ID_TEST][$quest['ID_QUESTION']] = null;
        }
        $session['TESTS'] = $tests;
        $session['countQuestion'] = count($allQuestions);
        $currentTest->timeInit();
        $session->close();
    }

    /**
     * @param $testId
     * @return bool
     */
    public static function testDone($testId)
    {
        $user = User::findOne(Yii::$app->user->identity->ID_USER);
        $results = $user->getResults()->where(['FID_TEST' => $testId ])->count();
        return empty($results);
    }

    /**
     *
     */
    public function timeInit()
    {
        $session = Yii::$app->session;
        $session->open();
        $session['initialTime'] = time();
        $session['endTime'] = $session['initialTime'] + 1800;
        $session->close();
    }

    /**
     * @return array
     */
    public function timeProgress(){

        $session = Yii::$app->session;
        $session->open();
        $endTime = $session['endTime'] - time();
        $session->close();

        $min = substr(floor(($endTime / 60) % 60), -2);
        $sec = substr($endTime % 60, -2);
        return ['min' => $min, 'sec' => $sec];
    }

    /**
     * Склоняет слово
     * @param $number
     * @param $after
     * @return mixed
     */
    public static function words($number, $after) {
        $cases = array (2, 0, 1, 1, 1, 2);
        return $after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->TITLE_TEST = Html::encode($this->TITLE_TEST);
        return parent::beforeSave($insert);
    }

    /**
     * @param $tests
     */
    public function saveTest($tests)
    {
        foreach ($tests as $key => $value) {
            $testModel = new Test();
            if ($value != "") {
                $testModel->TITLE_TEST = $value;
                $testModel->save();
            }
        }
    }
}