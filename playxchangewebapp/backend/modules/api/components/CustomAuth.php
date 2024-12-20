<?php
namespace backend\modules\api\components;
use Yii;
use yii\filters\auth\AuthMethod;
class CustomAuth extends AuthMethod
{
    public $auth;

    public function authenticate($user, $request, $response)
    {
        $strToken = Yii::$app->request->getQueryParam('access-token');
        if ($this->auth)
        {
            $identity = call_user_func($this->auth, $strToken);
            if ($identity === null) {
                return null;
            }
            return $identity;
        }
        return null;

    }
}