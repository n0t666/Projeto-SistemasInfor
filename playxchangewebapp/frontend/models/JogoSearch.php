<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Jogo;

class JogoSearch extends Jogo
{
    public $order, $plataforma_id;

    public function rules()
    {
        return [
            [['id', 'distribuidora_id', 'editora_id', 'franquia_id', 'plataforma_id'], 'integer'],
            [['nome', 'dataLancamento'], 'safe'],
            ['order', 'safe'],
        ];
    }

    public function scenarios()
    {

        return Model::scenarios();
    }


    public function search($params)
    {
        $query = Jogo::find()->joinWith(['produtos', 'utilizadoresjogos'])
            ->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        switch ($this->order) {
            case 'preco_asc':
                $query->orderBy(['produtos.preco' => SORT_ASC]);
                break;
            case 'preco_desc':
                $query->orderBy(['produtos.preco' => SORT_DESC]);
                break;
            case 'data_lancamento_asc':
                $query->orderBy(['dataLancamento' => SORT_ASC]);
                break;
            case 'data_lancamento_desc':
                $query->orderBy(['dataLancamento' => SORT_DESC]);
                break;
            case 'nome_asc':
                $query->orderBy(['nome' => SORT_ASC]);
                break;
            case 'nome_desc':
                $query->orderBy(['nome' => SORT_DESC]);
                break;
            case 'popular_asc':
                $query->joinWith(['utilizadoresjogos u'])
                    ->groupBy('jogos.id')
                    ->orderBy(['COUNT(CASE WHEN u.isJogado = 1 THEN 1 END)' => SORT_ASC]);
                break;
            case 'popular_desc':
                $query->joinWith(['utilizadoresjogos u'])
                    ->groupBy('jogos.id')
                    ->orderBy(['COUNT(CASE WHEN u.isJogado = 1 THEN 1 END)' => SORT_DESC]);
                break;
        }

        if ($this->plataforma_id) {
            if ($this->plataforma_id != 0) {
                $query->andWhere(['produtos.plataforma_id' => $this->plataforma_id]);
            } else {
                $query->andWhere(['produtos.plataforma_id' => null]);
            }

        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['distribuidora_id' => $this->distribuidora_id])
            ->andFilterWhere(['editora_id' => $this->editora_id])
            ->andFilterWhere(['franquia_id' => $this->franquia_id]);


        return $dataProvider;
    }
}
