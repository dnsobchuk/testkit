<?php

namespace app\models;

use yii\data\ActiveDataProvider;


/**
 * TestSearch represents the model behind the search form of `app\models\Test`.
 */
class TestSearch extends Test
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TITLE_TEST'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Test::find()->orderBy('ID_TEST');
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $this->load($params);
        if (!$this->validate()) return $dataProvider;
        $query->andFilterWhere(['like', 'LOWER(TITLE_TEST)', strtolower($this->TITLE_TEST)]);
        return $dataProvider;
    }
}
