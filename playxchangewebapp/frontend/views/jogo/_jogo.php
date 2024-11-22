<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$interaction = \common\models\UtilizadorJogo::find()
    ->where(['jogo_id' => $jogo->id, 'utilizador_id' => Yii::$app->user->id])
    ->one();


?>
    <div class="card game-card">
        <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . $jogo->imagemCapa; ?>" class="game-poster img-fluid" alt="Game Poster">

        <?php if (Yii::$app->user->can('adicionarFavoritos') || Yii::$app->user->can('adicionarJogados')): ?>
            <div class="center-links">
                <?php $form = ActiveForm::begin(['action' => ['utilizador-jogo/update']]); ?>
                <?= $form->field($jogo, 'id')->hiddenInput(['value' => $jogo->id])->label(false) ?>

                <button type="submit" title="Adicionar aos Favoritos" class="btn btn-favorite <?= ($interaction && $interaction->isFavorito) ? 'ativo' : ''; ?>" name="action" value="1">
                    <i class="fas fa-heart"></i>
                </button>


                <button type="submit"  title="Adicionar aos Jogados"  class="btn btn-played <?= ($interaction && $interaction->isJogado) ? 'ativo' : ''; ?>" name="action" value="2" >
                    <i class="fas fa-check-circle"></i>
                </button>


                <button type="submit" title="Adicionar aos Desejados" class="btn btn-wishlist <?= ($interaction && $interaction->isDesejado) ? 'ativo' : ''; ?>" name="action" value="3">
                    <i class="fas fa-star"></i>
                </button>

                <?php ActiveForm::end(); ?>
            </div>
        <?php endif; ?>
    </div>