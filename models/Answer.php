<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "ANSWERS".
 *
 * @property int $ID_ANSWER _autoIncremented
 * @property int $FID_QUESTION ВК на вопросы
 * @property string $CONTENT_ANSWER Текст ответа
 * @property int $IS_RIGHT Правильный ответ
 */
class Answer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ANSWERS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FID_QUESTION'], 'required'],
            [['ID_ANSWER', 'FID_QUESTION', 'IS_RIGHT'], 'integer'],
            [['CONTENT_ANSWER'], 'string','max' => 1000],
            [['CONTENT_ANSWER'], 'trim'],
            [['ID_ANSWER'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_ANSWER' => 'ID ответа',
            'FID_QUESTION' => 'Текст вопроса',
            'CONTENT_ANSWER' => 'Текст ответа',
            'IS_RIGHT' => 'Верно/неверно',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['ID_QUESTION' => 'FID_QUESTION']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->CONTENT_ANSWER = Html::encode($this->CONTENT_ANSWER);
        return parent::beforeSave($insert);
    }
}
