    <?php
    Yii::setAlias('@common', dirname(__DIR__));
    Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
    Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
    Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
    Yii::setAlias('@root', dirname(dirname(__DIR__)));
    Yii::setAlias('@uploadsFrontend', '/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/');


    /*
     * Tudo o que é path, é possível para efetuar o processo de guardar porém dá forbidden se tentar-se mostrar no backend/frontend
     * Agora tudo o que é URL, é público e é possível ter acesso
     */
    Yii::setAlias('@capasJogoPath', '@frontend/web/uploads/jogos/capas');
    Yii::setAlias('@screenshotsJogoPath', '@frontend/web/uploads/jogos/screenshots');
    Yii::setAlias('@perfilPath', '@frontend/web/uploads/users/perfil');
    Yii::setAlias('@utilsPath', '@frontend/web/uploads/utils');

    /* Produção */
    Yii::setAlias('@utilsUrl', 'http://172.22.21.219:8081/uploads/utils');
    Yii::setAlias('@capasJogoUrl', 'http://172.22.21.219:8081/uploads/jogos/capas');
    Yii::setAlias('@imagesUrl', 'http://172.22.21.219:8081/images/');
    Yii::setAlias('@perfilUrl', 'http://172.22.21.219:8081/uploads/users/perfil');
    Yii::setAlias('@screenshotsJogoUrl', 'http://172.22.21.219:8081/uploads/jogos/screenshots');


    /* Desenvolvimento
    Yii::setAlias('@utilsUrl', '/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/utils');
    Yii::setAlias('@capasJogoUrl', '/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/jogos/capas');
    Yii::setAlias('@imagesUrl', '/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/');
    Yii::setAlias('@perfilUrl', '/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/users/perfil');
    Yii::setAlias('@screenshotsJogoUrl', '/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/jogos/screenshots');
*/
    /* Desenvolvimento android
    Yii::setAlias('@utilsUrl', 'http://10.0.2.2/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/utils');
    Yii::setAlias('@capasJogoUrl', 'http://10.0.2.2/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/jogos/capas');
    Yii::setAlias('@imagesUrl', 'http://10.0.2.2/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/');
    Yii::setAlias('@perfilUrl', 'http://10.0.2.2/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/users/perfil');
    Yii::setAlias('@screenshotsJogoUrl', 'http://10.0.2.2/Projeto-SistemasInfor/playxchangewebapp/frontend/web/uploads/jogos/screenshots');
    */


    Yii::setAlias('@mobileIp' , 'http://10.0.2.2');




