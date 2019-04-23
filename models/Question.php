<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "QUESTIONS".
 *
 * @property int $ID_QUESTION _autoIncremented
 * @property int $FID_TEST ВК на тесты
 * @property string $CONTENT_QUESTION Текст вопроса
 */
class Question extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'QUESTIONS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FID_TEST'], 'required'],
            [['ID_QUESTION', 'FID_TEST'], 'integer'],
            [['CONTENT_QUESTION'], 'string', 'max' => 4000],
            [['ID_QUESTION'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_QUESTION' => 'ID вопроса',
            'FID_TEST' => 'Fid  Test',
            'CONTENT_QUESTION' => 'Текст вопроса',
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
    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['FID_QUESTION' => 'ID_QUESTION']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->CONTENT_QUESTION = Html::encode($this->CONTENT_QUESTION);
        return parent::beforeSave($insert);
    }
}
