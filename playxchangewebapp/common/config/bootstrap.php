    <?php
    Yii::setAlias('@common', dirname(__DIR__));
    Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
    Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
    Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
    Yii::setAlias('@capasJogo', '@frontend/web/uploads/jogos/capas');
    Yii::setAlias('@screenshotsJogo', '@frontend/web/uploads/jogos/screenshots');
    Yii::setAlias('@fotosPerfil', '@frontend/web/uploads/users/perfil');