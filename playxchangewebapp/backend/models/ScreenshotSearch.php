<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Screenshot;

/**
 * ScreenshotSearch represents the model behind the search form of `common\models\Screenshot`.
 */
class ScreenshotSearch extends Screenshot
{

    public $globalSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {

        return [
            [['id', 'jogo_id'], 'integer'],
            [['caminho'], 'safe'],
            [['globalSearch'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Screenshot::find();

        $query->joinWith(['jogo']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
           $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->globalSearch)) {
            $query->andFilterWhere(['or',
                ['like', 'jogo.nome', $this->globalSearch],
                ['like', 'jogo.id', $this->globalSearch],
            ]);
        }

        return $dataProvider;
    }
}
