<?php

namespace common\models;

use Yii;
use yii\base\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

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
 * @property Avaliacao[] $avaliacos
 * @property Distribuidora $distribuidora
 * @property Editora $editora
 * @property Franquia $franquia
 * @property Genero[] $generos
 * @property Lista[] $listas
 * @property Produto[] $produtos
 * @property Screenshot[] $screenshots
 * @property Tag[] $tags
 * @property UtilizadorJogo[] $utilizadoresjogos
 * @property Userdata[] $utilizadors
 * @property Userdata[] $utilizadors0
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
            [['dataLancamento'], 'date', 'format' => 'php:d-m-Y'],
            [['descricao'], 'string'],
            [['franquia_id', 'distribuidora_id', 'editora_id'], 'integer'],
            [['nome'], 'string', 'max' => 200],
            [['imagemCapa'], 'string', 'max' => 255],
            [['trailerLink'],'url','defaultScheme' => 'https'],
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
            'dataLancamento' => 'Data De Lançamento',
            'descricao' => 'Descrição',
            'trailerLink' => 'Trailer',
            'franquia_id' => 'Franquia',
            'imagemCapa' => 'Capa',
            'distribuidora_id' => 'Distribuidora',
            'editora_id' => 'Editora',
        ];
    }

    /**
     * Gets query for [[Avaliacos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['jogo_id' => 'id']);
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

    /**
     * Gets query for [[Utilizadoresjogos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadoresjogos()
    {
        return $this->hasMany(UtilizadorJogo::class, ['jogo_id' => 'id']);
    }

    /**
     * Gets query for [[Utilizadors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadorjogos()
    {
        return $this->hasMany(Userdata::class, ['id' => 'utilizador_id'])->viaTable('utilizadoresjogos', ['jogo_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dataLancamento'],
                ],
                'value' => function ($event) {
                    return $this->dataLancamento ? date('d-m-Y', strtotime($this->dataLancamento)) : null; // Se houver uma data de lançamento, format para algo do tipo 10/02/2024,caso contrário definir como null
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dataLancamento'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dataLancamento'],
                ],
                'value' => function ($event) {
                    try {
                        if (empty($this->dataLancamento)) {
                            $this->dataLancamento = date('Y-m-d');
                        } else {
                            $this->dataLancamento = Yii::$app->formatter->asDate($this->dataLancamento, 'php:Y-m-d');
                        }
                    } catch (\Exception $e) {
                        Yii::error("Erro durante a conversão" . $e->getMessage(), __METHOD__);
                        $this->dataLancamento = date('Y-m-d');
                    }

                    return $this->dataLancamento;
                },
            ],
        ];
    }
    }

