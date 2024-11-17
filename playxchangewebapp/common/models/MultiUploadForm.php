<?php

namespace common\models;

use Yii;
use yii\base\Model;

class MultiUploadForm extends Model
{
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFiles' => 'Imagens',
        ];
    }

    public function upload($alias){
        $path = Yii::getAlias($alias);

        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $file->name = Yii::$app->getSecurity()->generateRandomString() . '.' . $file->extension;
                $filePath = $path . DIRECTORY_SEPARATOR . $file->name;
                $file->saveAs($filePath);
            }
            return true;
        } else {
            return false;
        }
    }

}