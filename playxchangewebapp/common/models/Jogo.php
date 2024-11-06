<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Jogos".
 *
 * @property int $id
 * @property string $nome
 * @property string $dataLancamento
 * @property string|null $descricao
 * @property string $trailerLink
 * @property int|null $franquia_id
 * @property string $imagemCapa
 * @property int $publicadora_id
 * @property int $editora_id
 */
class Jogo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Jogos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'dataLancamento', 'trailerLink', 'imagemCapa', 'publicadora_id', 'editora_id'], 'required'],
            [['dataLancamento'], 'safe'],
            [['descricao'], 'string'],
            [['franquia_id', 'publicadora_id', 'editora_id'], 'integer'],
            [['nome'], 'string', 'max' => 200],
            [['trailerLink', 'imagemCapa'], 'string', 'max' => 255],
            [['editora_id'], 'exist', 'skipOnError' => true, 'targetClass' => Editora::class, 'targetAttribute' => ['editora_id' => 'id']],
            [['franquia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Franquia::class, 'targetAttribute' => ['franquia_id' => 'id']],
            [['publicadora_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publicadora::class, 'targetAttribute' => ['publicadora_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'dataLancamento' => 'Data Lancamento',
            'descricao' => 'Descricao',
            'trailerLink' => 'Trailer Link',
            'franquia_id' => 'Franquia ID',
            'imagemCapa' => 'Imagem Capa',
            'publicadora_id' => 'Publicadora ID',
            'editora_id' => 'Editora ID',
        ];
    }

    public function getTags(){
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('jogosTags', ['jogo_id' => 'id']);
    }
}
