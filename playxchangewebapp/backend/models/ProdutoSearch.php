<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\produto;

/**
 * ProdutoSearch represents the model behind the search form of `common\models\produto`.
 */
class ProdutoSearch extends produto
{
    public $globalSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jogo_id', 'plataforma_id', 'quantidade'], 'integer'],
            [['preco'], 'number'],
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
    public function search($params,$jogoId = null)
    {
        $query = produto::find();

        $query->joinWith(['jogo', 'plataforma']);


        if ($jogoId !== null) {
            $query->andWhere(['produtos.jogo_id' => $jogoId]);
        }

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
                ['like', 'produtos.id', $this->globalSearch],
                ['like', 'plataformas.nome', $this->globalSearch],
            ]);
        }

        return $dataProvider;
    }
}
