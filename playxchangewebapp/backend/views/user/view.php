<?php

use common\models\User;
use common\models\Userdata;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $userData Userdata */
/* @var $roles[] */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="container-fluid">
    <div class="user-banner mb-4" style="background-image: url('<?= $userData->fotoCapa ?>'); height: 250px; background-size: cover; background-position: center;">
        <div class="profile-picture d-flex justify-content-center position-absolute" style="bottom: -60px; left: 50%; transform: translateX(-50%);">
            <img src="<?= $userData->getFotoPerfil() ?>" alt="User Profile Picture" class="img-fluid rounded-circle border border-light" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
        </div>
    </div>
    <div class="card user-backend-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'username',
                            //'auth_key',
                            //'password_hash',
                            //'password_reset_token',
                            'email:email',
                            [
                                'attribute' => 'status',
                                'value' => function($model) {
                                    return $model->getStatusLabel();
                                },
                                'label' => 'Status',
                            ],
                            [
                                'attribute' => 'Criado em',
                                'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:m-d-Y H:i:s'),
                                'label' => 'Criado em',
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => Yii::$app->formatter->asDatetime($model->updated_at, 'php:m-d-Y H:i:s'),
                                'label' => 'Atualizado em',
                            ],
                            [
                                'attribute' => 'roles',
                                'label' => 'Roles',
                                'value' => function ($model) {
                                    $roles = Yii::$app->authManager->getRolesByUser($model->id);
                                    return reset($roles)->name; // Primeiro role tendo em conta especificações do sistema
                                },
                            ],
                            //'verification_token',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
            <?php if ($userData): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Perfil do utilizador</h3>
                        <?= DetailView::widget([
                            'model' => $userData,
                            'attributes' => [
                                'nome',
                                [
                                    'attribute' => 'dataNascimento',
                                    'value' => $userData->dataNascimento ? Yii::$app->formatter->asDate($userData->dataNascimento,'php:m-d-Y') : 'N/A',
                                ],
                                'nif',
                                [
                                    'attribute' => 'biografia',
                                    'value' => $userData->biografia ? $userData->biografia  : 'N/A',
                                ],
                                [
                                    'attribute' => 'privacidadeSeguidores',
                                    'label' => 'Privacidade dos Seguidores',
                                    'value' => $userData->getPrivacidadeSeguidoresLabel(),
                                ],
                                [
                                    'attribute' => 'privacidadePerfil',
                                    'label' => 'Privacidade do Perfil',
                                    'value' => $userData->getPrivacidadePerfilLabel(),
                                ],
                                [
                                    'attribute' => 'privacidadeJogos',
                                    'label' => 'Privacidade dos Jogos',
                                    'value' => $userData->getPrivacidadeJogosLabel(),
                                ],
                            ],
                        ]) ?>
                    </div>
                    <!--.col-md-12-->
                </div>
                <!--.row-->
            <?php endif; ?>
            <div class="row mt-4">
                <div class="col-md-12 text-left">
                    <?= Html::a('<i class="fas fa-comments"></i> Ver Comentários do Utilizador', ['comentario/index', 'userId' => $model->id], [
                        'class' => 'btn btn-primary btn-lg',
                        'role' => 'button',
                        'style' => 'border-radius: 25px;',
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>
