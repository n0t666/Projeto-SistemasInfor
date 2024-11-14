<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Chave;

/**
 * ChaveSearch represents the model behind the search form of `common\models\Chave`.
 */
class ChaveSearch extends Chave
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'produto_id', 'plataforma_id', 'isUsada'], 'integer'],
            [['chave', 'dataGeracao', 'dataExpiracao'], 'safe'],
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
        $query = Chave::find();

        $query->joinWith(['produto.jogo', 'plataforma']);

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
            $query->andFilterWhere(['or', // Caso o termo de pesquisa dê match com o nome, descricao,distribuido, editora ou franquia
                ['like', 'produto.nome', $this->globalSearch],
                ['like', 'jogo.nome', $this->globalSearch],
                ['like', 'plataforma.nome', $this->globalSearch],
            ]);
        }

        return $dataProvider;
    }
}
