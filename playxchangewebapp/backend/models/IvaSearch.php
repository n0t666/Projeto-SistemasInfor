<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Iva;

/**
 * IvaSearch represents the model behind the search form of `common\models\Iva`.
 */
class IvaSearch extends Iva
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome'], 'safe'],
            [['percentagem'], 'number'],
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
        $query = Iva::find();

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
                ['like', 'nome', $this->globalSearch],
                ['like', 'id', $this->globalSearch],
                ['like', 'percentagem', $this->globalSearch],
            ]);
        }

        return $dataProvider;
    }
}
