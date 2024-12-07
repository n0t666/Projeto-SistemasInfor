<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserData;

/**
 * UserSearch represents the model behind the search form of `common\models\UserData`.
 */
class UserSearch extends UserData
{
    public $globalSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'privacidadeSeguidores', 'privacidadePerfil', 'privacidadeJogos'], 'integer'],
            [['nome', 'nif', 'dataNascimento', 'biografia', 'fotoCapa', 'fotoPerfil'], 'safe'],
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
        $query = UserData::find();

        $query->joinWith(['user']);

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
                ['like', 'user.username', $this->globalSearch],
                ['like', 'user.id', $this->globalSearch],
                ['like', 'nif', $this->globalSearch],
            ]);
        }

        return $dataProvider;
    }
}
