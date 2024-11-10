<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "votosFuncionalidades".
 *
 * @property int $utilizador_id
 * @property int $funcionalidade_id
 * @property int $voto
 */
class VotoFuncionalidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'votosFuncionalidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'funcionalidade_id', 'voto'], 'required'],
            [['utilizador_id', 'funcionalidade_id', 'voto'], 'integer'],
            [['utilizador_id', 'funcionalidade_id'], 'unique', 'targetAttribute' => ['utilizador_id', 'funcionalidade_id']],
            [['funcionalidade_id'], 'exist', 'skipOnError' => true, 'targetClass' => SugestaoFuncionalidade::class, 'targetAttribute' => ['funcionalidade_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserData::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'utilizador_id' => 'Utilizador ID',
            'funcionalidade_id' => 'Funcionalidade ID',
            'voto' => 'Voto',
        ];
    }

    /**
     * Gets query for [[Funcionalidade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFuncionalidade()
    {
        return $this->hasOne(SugestaoFuncionalidade::class, ['id' => 'funcionalidade_id']);
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
}
