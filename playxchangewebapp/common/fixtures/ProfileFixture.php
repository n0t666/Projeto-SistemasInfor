<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class ProfileFixture extends ActiveFixture
{
    public $modelClass = 'common\models\Userdata';
    public $depends = ['common\fixtures\UserFixture'];
}
