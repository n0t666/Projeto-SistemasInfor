<?php
/* @var $model Comentario */

use common\models\Comentario;
use common\models\GostoComentario;
use frontend\controllers\ComentarioController;
use kartik\rating\StarRating;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;

$this->registerJsFile(
    '@web/js/review.js',
    ['depends' => [JqueryAsset::class]]
);

$gostocomentario = null;

if (ComentarioController::isLikedByCurrentUser($model->id)) {
    $gostocomentario = $model->getGostoscomentarios()->where(['utilizador_id' => Yii::$app->user->id])->one();
} elseif (!Yii::$app->user->isGuest) {
    $gostocomentario = new GostoComentario();
    $gostocomentario->comentario_id = $model->id;
    $gostocomentario->utilizador_id = Yii::$app->user->id;
}

?>

<div class="review-card mb-4 p-3 rounded shadow">
    <div class="d-flex align-items-start">
        <img src="<?= $model->utilizador->getFotoPerfil() ?>" alt="User Photo" class="rounded-circle user-photo me-3"
             width="50" height="50">
        <div class="review-content">
            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= \yii\helpers\Url::to(['utilizador/profile','username' => $model->utilizador->user->username])?>" class="text-decoration-none review-username">
                    <h5 class="user-name mb-2 me-2"><?= Html::encode($model->utilizador->user->username) ?></h5>
                </a>


                <?php
                if ($model->utilizador->getAvaliacoes()) {
                    $avaliacao = $model->utilizador->getAvaliacoes()->where(['jogo_id' => $model->jogo])->one();
                    if ($avaliacao) {
                        echo StarRating::widget([
                            'name' => 'current rating',
                            'value' => (float)$avaliacao->numEstrelas,
                            'pluginOptions' => [
                                'size' => 'xs',
                                'showClear' => false,
                                'showCaption' => false,
                                'disabled' => true,
                                'theme' => 'krajee-uni',
                                'filledStar' => '★',
                                'emptyStar' => '☆'
                            ]
                        ]);
                    };
                }
                ?>
            </div>
            <p class="review-text mb-2"><?= Html::encode($model->comentario) ?></p>
            <div class="d-flex align-items-center">
                <?php if ($gostocomentario && !$gostocomentario->isNewRecord): ?>
                    <button class="btn like-btn p-0 liked" <?= Yii::$app->user->isGuest ? 'disabled' : ''; ?>>
                        <i class="fas fa-heart"></i>
                    </button>
                <?php else: ?>
                    <button class="btn like-btn p-0" <?= Yii::$app->user->isGuest ? 'disabled' : ''; ?> >
                        <i class="far fa-heart"></i>
                    </button>
                <?php endif; ?>
                <span class="ms-1 likes-count"><?= count($model->gostoscomentarios) ?></span>
            </div>
        </div>
        <?php
        $form = ActiveForm::begin([
            'action' => ['gosto-comentario/create'],
            'method' => 'post',
            'options' => ['style' => 'display:none;', 'class' => 'like-form']
        ]);
        if ($gostocomentario) {
            echo $form->field($gostocomentario, 'utilizador_id')->hiddenInput()->label(false) ;
            echo $form->field($gostocomentario, 'comentario_id')->hiddenInput()->label(false) ;
        }
        ActiveForm::end();
        ?>

        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $model->utilizador_id): ?>
            <?= Html::a('<i class="fas fa-trash"></i>', ['/comentario/delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm ms-auto',
                'data' => [
                    'confirm' => 'Tem a certeza que deseja apagar?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>

    </div>
</div>