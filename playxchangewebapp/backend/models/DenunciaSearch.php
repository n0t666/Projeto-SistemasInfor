<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Denuncia;

/**
 * DenunciaSearch represents the model behind the search form of `common\models\Denuncia`.
 */
class DenunciaSearch extends Denuncia
{
    public $globalSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denunciante_id', 'denunciado_id', 'estado'], 'integer'],
            [['motivo', 'dataDenuncia'], 'safe'],
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
        $query = Denuncia::find();

        $query->alias('denuncia');
        $query->joinWith(['denunciante denuncianteAlias', 'denunciado denunciadoAlias']);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'denunciante_id' => $this->denunciante_id,
            'denunciado_id' => $this->denunciado_id,
            'dataDenuncia' => $this->dataDenuncia,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'motivo', $this->motivo]);

        return $dataProvider;
    }
}
