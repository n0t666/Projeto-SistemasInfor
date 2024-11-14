<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;
class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload($alias)
    {
        if ($this->validate()) {
            $key = Yii::$app->getSecurity()->generateRandomString();
            $this->imageFile->saveAs($alias . $key. '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

}