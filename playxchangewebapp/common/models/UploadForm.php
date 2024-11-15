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
            /*
            $filename = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::getAlias($alias);
            $filePath = $path . DIRECTORY_SEPARATOR . $filename . '.' . $this->imageFile->extension;
            */

            $path = Yii::getAlias($alias);
            $this->imageFile->name = Yii::$app->getSecurity()->generateRandomString() . '.' . $this->imageFile->extension;
            $filePath = $path . DIRECTORY_SEPARATOR . $this->imageFile->name ;

            if ($this->imageFile->saveAs($filePath)) {
                //$this->imageFile = $filename . '.' . $this->imageFile->extension;
                //$this->filename = $filename . '.' . $this->imageFile->extension;
                return true;
            }
            return false;
        } else {
            return false;
        }
    }


}