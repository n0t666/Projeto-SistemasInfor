<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jogos".
 *
 * @property int $id
 * @property string $nome
 * @property string $dataLancamento
 * @property string|null $descricao
 * @property string $trailerLink
 * @property int|null $franquia_id
 * @property string $imagemCapa
 * @property int $distribuidora_id
 * @property int $editora_id
 *
 * @property Avaliaco[] $avaliacos
 * @property Distribuidora $distribuidora
 * @property Editora $editora
 * @property Franquia $franquia
 * @property Genero[] $generos
 * @property Jogosgenero[] $jogosgeneros
 * @property Jogostag[] $jogostags
 * @property Lista[] $listas
 * @property Listasjogo[] $listasjogos
 * @property Produto[] $produtos
 * @property Screenshot[] $screenshots
 * @property Tag[] $tags
 * @property Utilizadoresjogo[] $utilizadoresjogos
 * @property Userdatum[] $utilizadors
 * @property Userdatum[] $utilizadors0
 */
class Jogo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jogos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'dataLancamento', 'trailerLink', 'imagemCapa', 'distribuidora_id', 'editora_id'], 'required'],
            [['dataLancamento'], 'safe'],
            [['descricao'], 'string'],
            [['franquia_id', 'distribuidora_id', 'editora_id'], 'integer'],
            [['nome'], 'string', 'max' => 200],
            [['trailerLink', 'imagemCapa'], 'string', 'max' => 255],
            [['editora_id'], 'exist', 'skipOnError' => true, 'targetClass' => Editora::class, 'targetAttribute' => ['editora_id' => 'id']],
            [['franquia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Franquia::class, 'targetAttribute' => ['franquia_id' => 'id']],
            [['distribuidora_id'], 'exist', 'skipOnError' => true, 'targetClass' => Distribuidora::class, 'targetAttribute' => ['distribuidora_id' => 'id']],
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
            'distribuidora_id' => 'Distribuidora ID',
            'editora_id' => 'Editora ID',
        ];
    }

    /**
     * Gets query for [[Avaliacos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacos()
    {
        return $this->hasMany(Avaliaco::class, ['jogo_id' => 'id']);
    }

    /**
     * Gets query for [[Distribuidora]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistribuidora()
    {
        return $this->hasOne(Distribuidora::class, ['id' => 'distribuidora_id']);
    }

    /**
     * Gets query for [[Editora]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEditora()
    {
        return $this->hasOne(Editora::class, ['id' => 'editora_id']);
    }

    /**
     * Gets query for [[Franquia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFranquia()
    {
        return $this->hasOne(Franquia::class, ['id' => 'franquia_id']);
    }

    /**
     * Gets query for [[Generos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGeneros()
    {
        return $this->hasMany(Genero::class, ['id' => 'genero_id'])->viaTable('jogosgeneros', ['jogo_id' => 'id']);
    }

    /**
     * Gets query for [[Jogosgeneros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogosgeneros()
    {
        return $this->hasMany(Jogosgenero::class, ['jogo_id' => 'id']);
    }

    /**
     * Gets query for [[Jogostags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogostags()
    {
        return $this->hasMany(Jogostag::class, ['jogo_id' => 'id']);
    }

    /**
     * Gets query for [[Listas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListas()
    {
        return $this->hasMany(Lista::class, ['id' => 'lista_id'])->viaTable('listasjogos', ['jogo_id' => 'id']);
    }


    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['jogo_id' => 'id']);
    }

    /**
     * Gets query for [[Screenshots]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScreenshots()
    {
        return $this->hasMany(Screenshot::class, ['jogo_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('jogostags', ['jogo_id' => 'id']);
    }




}
