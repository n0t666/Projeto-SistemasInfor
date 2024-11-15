<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $filename;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload($alias)
    {
        if ($this->validate()) {
            $filename = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::getAlias($alias);
            $filePath = $path . DIRECTORY_SEPARATOR . $filename . '.' . $this->imageFile->extension;

            if ($this->imageFile->saveAs($filePath)) {
                $this->filename = $filename . '.' . $this->imageFile->extension;
                return true;
            }
            return false;
        } else {
            return false;
        }
    }


}