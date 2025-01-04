<?php
use common\models\Jogo;
use common\models\User;
use yii\bootstrap5\Html;
use yii\helpers\Url;

// O instaceof foi utilizado para evitar criar vários ficheiros para mostrar o card do jogo / user , e basicamente verifica a que classe o model pertence

?>
<?php if ($model instanceof Jogo): ?>
    <div class="list-group-item list-group-item-action searchResult-item p-3">
        <div class="d-flex align-items-start align-items-md-center">
            <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . Html::encode($model->imagemCapa); ?>" alt="Game Cover" class="searchResult-img me-3">
            <div class="flex-grow-1">
                <h5 class="mb-1">
                    <a href="<?= Url::to(['jogo/view', 'id' => $model->id]) ?>" class="searchResult-link"><?= Html::encode($model->nome) ?></a>
                </h5>
                <p class="searchResult-description mb-0">
                    <?php if ($model->descricao && strlen($model->descricao) > 0) {
                        //mb_strimwidth foi utilizado aqui para limitar os caracters da string
                        // sendo os seguintes parametros: 1º - a string em questão, 2º - a posição para começar do caracter, 3º - a posicao do caracter que acaba e por fim o que deve aparacer quando atigir a posição máxima
                       Html::encode(mb_strimwidth($model->descricao, 0, 250, '...'));
                    }  ?>
                </p>
            </div>
        </div>
    </div>
<?php elseif ($model instanceof User && $model->profile != null): ?>
    <div class="list-group-item list-group-item-action searchResult-item p-3">
        <div class="d-flex align-items-start align-items-md-center">
            <?php if ($model->profile && $model->profile->getFotoPerfil()): ?>
                <img src="<?= Html::encode($model->profile->getFotoPerfil()) ?>" alt="User Profile" class="searchResult-profileImg me-3">
            <?php endif; ?>
            <div class="flex-grow-1">
                <h5 class="mb-1">
                    <a href="<?= Url::to(['utilizador/profile', 'username' => $model->username]) ?>" class="searchResult-link"><?= Html::encode($model->username) ?></a>
                </h5>
                <p class="searchResult-biography mb-0">
                    <?php if($model->profile->biografia && strlen($model->profile->biografia) > 0) {
                        Html::encode(mb_strimwidth($model->profile->biografia, 0, 250, '...'));
                    } ?>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>
