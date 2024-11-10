<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sugestoesfuncionalidades".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property string $descricao
 * @property string $titulo
 * @property string|null $dataSugestao
 * @property int $estado
 *
 * @property UserData $utilizador
 * @property UserData[] $utilizadores
 * @property Votofuncionalidade[] $votosfuncionalidades
 */
class SugestaoFuncionalidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sugestoesfuncionalidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'descricao', 'titulo', 'estado'], 'required'],
            [['utilizador_id', 'estado'], 'integer'],
            [['descricao'], 'string'],
            [['dataSugestao'], 'safe'],
            [['titulo'], 'string', 'max' => 80],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserData::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utilizador_id' => 'Utilizador ID',
            'descricao' => 'Descricao',
            'titulo' => 'Titulo',
            'dataSugestao' => 'Data Sugestao',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(UserData::class, ['id' => 'utilizador_id']);
    }

    /**
     * Gets query for [[Utilizadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotosUtilizadores()
    {
        return $this->hasMany(UserData::class, ['id' => 'utilizador_id'])->viaTable('votosfuncionalidades', ['funcionalidade_id' => 'id']);
    }

    /**
     * Gets query for [[Votosfuncionalidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotosfuncionalidades()
    {
        return $this->hasMany(Votofuncionalidade::class, ['funcionalidade_id' => 'id']);
    }
}
