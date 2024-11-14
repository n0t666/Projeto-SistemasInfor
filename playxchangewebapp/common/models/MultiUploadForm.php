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
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload($alias){
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $key = Yii::$app->getSecurity()->generateRandomString();
                $file->saveAs($alias . $key . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }

}