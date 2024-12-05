<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "userdata".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nome
 * @property string|null $nif
 * @property string|null $dataNascimento
 * @property string|null $biografia
 * @property string|null $fotoCapa
 * @property string|null $fotoPerfil
 * @property int|null $privacidadeSeguidores
 * @property int $privacidadeFavoritos
 * @property int|null $privacidadeJogos
 *
 * @property Avaliacao[] $avaliacos
 * @property Carrinho[] $carrinhos
 * @property CodigoPromocional[] $codigos
 * @property Comentario[] $comentarios
 * @property Userdata[] $denunciados
 * @property Userdata[] $denunciantes
 * @property Fatura[] $faturas
 * @property SugestaoFuncionalidade[] $funcionalidades
 * @property GostoComentario[] $gostoscomentarios
 * @property Jogo[] $jogos
 * @property Jogo[] $jogos0
 * @property Listabloqueio[] $listabloqueios
 * @property Listabloqueio[] $listabloqueios0
 * @property Lista[] $listas
 * @property Lista[] $listas0
 * @property Userdata[] $seguidors
 * @property Userdata[] $seguidos
 * @property SugestaoFuncionalidade[] $sugestoesfuncionalidades
 * @property User $user
 * @property Userdata[] $utilizadorBloqueados
 * @property UtilizadorJogo[] $utilizadoresjogos
 * @property Userdata[] $utilizadors
 * @property VotoFuncionalidade[] $votosfuncionalidades
 */
class Userdata extends \yii\db\ActiveRecord
{

    CONST STATUS_PUBLIC = 0; // Todos tem permissões para visualizar

    CONST STATUS_PRIVATE = 1; // Apenas o utilizador pode visualizar

    CONST STATUS_MUTUAL = 2; // Para pessoas que se seguem mutuamente


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userdata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'nome'], 'required'],
            [['user_id', 'privacidadeSeguidores', 'privacidadeFavoritos', 'privacidadeJogos'], 'integer'],
            [['dataNascimento'], 'safe'],
            [['nome'], 'string', 'max' => 200],
            ['nif', 'string','min' => 9, 'max' => 9],
            ['nif', 'unique', 'targetClass' => '\common\models\Userdata', 'message' => 'Este NIF já está associado a outra conta.'],
            [['biografia'], 'string', 'max' => 150],
            [['fotoCapa', 'fotoPerfil'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['privacidadeSeguidores', 'default', 'value' => self::STATUS_PUBLIC],
            ['privacidadeSeguidores', 'in', 'range' => [self::STATUS_PRIVATE, self::STATUS_PUBLIC, self::STATUS_MUTUAL]],
            ['privacidadeFavoritos', 'default', 'value' => self::STATUS_PUBLIC],
            ['privacidadeFavoritos', 'in', 'range' => [self::STATUS_PRIVATE, self::STATUS_PUBLIC, self::STATUS_MUTUAL]],
            ['privacidadeJogos', 'default', 'value' => self::STATUS_PUBLIC],
            ['privacidadeJogos', 'in', 'range' => [self::STATUS_PRIVATE, self::STATUS_PUBLIC, self::STATUS_MUTUAL]],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nome' => 'Nome',
            'nif' => 'Nif',
            'dataNascimento' => 'Data Nascimento',
            'biografia' => 'Biografia',
            'fotoCapa' => 'Foto Capa',
            'fotoPerfil' => 'Foto Perfil',
            'privacidadeSeguidores' => 'Privacidade Seguidores',
            'privacidadeFavoritos' => 'Privacidade Favoritos',
            'privacidadeJogos' => 'Privacidade Jogos',
        ];
    }

    /**
     * Gets query for [[Avaliacos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Carrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinho::class, ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Codigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodigos()
    {
        return $this->hasMany(CodigoPromocional::class, ['id' => 'codigo_id'])->viaTable('utilizacaocodigos', ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['id' => 'comentario_id'])->viaTable('gostoscomentarios', ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Denunciados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenunciados()
    {
        return $this->hasMany(Userdata::class, ['id' => 'denunciado_id'])->viaTable('denuncias', ['denunciante_id' => 'id']);
    }

    /**
     * Gets query for [[Denunciantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenunciantes()
    {
        return $this->hasMany(Userdata::class, ['id' => 'denunciante_id'])->viaTable('denuncias', ['denunciado_id' => 'id']);
    }

    /**
     * Gets query for [[Denuncias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportados()
    {
        return $this->hasMany(Denuncia::class, ['denunciante_id' => 'id']);
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenuncias()
    {
        return $this->hasMany(Denuncia::class, ['denunciado_id' => 'id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Funcionalidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFuncionalidades()
    {
        return $this->hasMany(SugestaoFuncionalidade::class, ['id' => 'funcionalidade_id'])->viaTable('votosfuncionalidades', ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Avaliacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Jogo::class, ['id' => 'jogo_id'])->viaTable('avaliacoes', ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Interacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInteracoes()
    {
        return $this->hasMany(Jogo::class, ['id' => 'jogo_id'])->viaTable('utilizadoresjogos', ['utilizador_id' => 'id']);
    }


    /**
     * Gets query for [[Listas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListas()
    {
        return $this->hasMany(Lista::class, ['idUtilizador' => 'id']);
    }


    /**
     * Gets query for [[Seguidors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores()
    {
        return $this->hasMany(Userdata::class, ['id' => 'seguidor_id'])->viaTable('seguidores', ['seguido_id' => 'id']);
    }

    /**
     * Gets query for [[Seguidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidos()
    {
        return $this->hasMany(Userdata::class, ['id' => 'seguido_id'])->viaTable('seguidores', ['seguidor_id' => 'id']);
    }

    /**
     * Gets query for [[Sugestoesfuncionalidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSugestoesfuncionalidades()
    {
        return $this->hasMany(SugestaoFuncionalidade::class, ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[UtilizadorBloqueados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadorBloqueados()
    {
        return $this->hasMany(Userdata::class, ['id' => 'utilizadorBloqueado_id'])
            ->viaTable('listabloqueios', ['utilizador_id' => 'id']);
    }

    /**
     * Gets query for [[Utilizadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadorBloqueios()
    {
        return $this->hasMany(Userdata::class, ['id' => 'utilizador_id'])
            ->viaTable('listabloqueios', ['utilizadorBloqueado_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dataNascimento'],
                ],
                'value' => function ($event) {
                    return $this->dataNascimento ? date('d-m-Y', strtotime($this->dataNascimento)) : null;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dataNascimento'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dataNascimento'],
                ],
                'value' => function ($event) {
                    try {
                        if (empty($this->dataNascimento)) {
                            $this->dataNascimento = date('Y-m-d');
                        } else {
                            $this->dataNascimento = Yii::$app->formatter->asDate($this->dataNascimento, 'php:Y-m-d');
                        }
                    } catch (\Exception $e) {
                        Yii::error("Erro durante a conversão" . $e->getMessage(), __METHOD__);
                        $this->dataNascimento = date('Y-m-d');
                    }
                    return $this->dataNascimento;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['fotoCapa'],
                ],
                'value' => function ($event) {
                    $file = Yii::getAlias('@perfilPath') . '/' . $this->fotoCapa;
                    if (!empty($this->fotoCapa) && file_exists($file)) {
                        return Yii::getAlias('@perfilUrl') . '/' . $this->fotoCapa;
                    }else{
                        return Yii::getAlias('@imagesUrl') . '/' . 'default_background.png';

                    }

                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['fotoPerfil'],
                ],
                'value' => function ($event) {
                    $file = Yii::getAlias('@perfilPath') . '/' . $this->fotoPerfil;
                    if (!empty($this->fotoPerfil) && file_exists($file)) {
                        return Yii::getAlias('@perfilUrl') . '/' . $this->fotoPerfil;
                    }else{
                        return Yii::getAlias('@imagesUrl') . '/' . 'default_user.jpg';
                    }
                },
            ],
        ];
    }
    public function getPrivacidadeSeguidoresLabel()
    {
        switch ($this->privacidadeSeguidores) {
            case self::STATUS_PUBLIC:
                return 'Público';
            case self::STATUS_PRIVATE:
                return 'Privado';
            case self::STATUS_MUTUAL:
                return 'Mútuo';
            default:
                return 'Desconhecido';
        }
    }

    public function getPrivacidadeFavoritosLabel()
    {
        switch ($this->privacidadeFavoritos) {
            case self::STATUS_PUBLIC:
                return 'Público';
            case self::STATUS_PRIVATE:
                return 'Privado';
            case self::STATUS_MUTUAL:
                return 'Mútuo';
            default:
                return 'Desconhecido';
        }
    }

    public function getPrivacidadeJogosLabel()
    {
        switch ($this->privacidadeJogos) {
            case self::STATUS_PUBLIC:
                return 'Público';
            case self::STATUS_PRIVATE:
                return 'Privado';
            case self::STATUS_MUTUAL:
                return 'Mútuo';
            default:
                return 'Desconhecido';
        }
    }






}
