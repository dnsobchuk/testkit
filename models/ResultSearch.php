<?php

namespace app\models;

use yii\db\Query;

/**
 * ResultSearch represents the model behind the search form of `app\models\Result`.
 */
class ResultSearch extends Result
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FID_USER'], 'integer'],
        ];
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return '';
    }

    /**
     * @param $value
     * @return array
     */
    public function setResult($value)
    {

        $userData = [];
        $users = User::find()->where(['like', 'LOWER(LOGIN)', strtolower($value['Result'])])->all();
        foreach ($users as $user) {
            $userData[] = $user->ID_USER;
        }
        return $this->FID_USER = $userData;
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return Query
     */
    public function search($params)
    {
        $query = Result::find()->orderBy(['ID_RESULT' => SORT_DESC]);

        $this->load($params);

        $query->andFilterWhere([
            'FID_USER' => $this->FID_USER,
        ]);

        return $query;
    }
}
