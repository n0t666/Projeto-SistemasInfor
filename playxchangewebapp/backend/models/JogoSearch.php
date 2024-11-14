<?php

namespace backend\models;

use common\models\Jogo;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JogoSearch represents the model behind the search form of `common\models\Jogo`.
 */
class JogoSearch extends Jogo
{

    public $globalSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'franquia_id', 'distribuidora_id', 'editora_id'], 'integer'],
            [['nome', 'dataLancamento', 'descricao', 'trailerLink', 'imagemCapa'], 'safe'],
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
        $query = Jogo::find();

        $query->joinWith(['distribuidora', 'editora', 'franquia']); // Fazer um join para ter acesso ao campo das tabelas relacionadas


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
                ['like', 'jogos.nome', $this->globalSearch],
                ['like', 'distribuidoras.nome', $this->globalSearch],
                ['like', 'editoras.nome', $this->globalSearch],
                ['like', 'franquias.nome', $this->globalSearch],
            ]);
        }
        return $dataProvider;
    }
}
