<?php

namespace backend\assets;

use yii\web\AssetBundle;

class CustomAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/mainLayoutOverride.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',

    ];
}
