<?php

namespace backend\controllers;

use yii\web\Controller;

class UtilsController extends Controller
{

    public static function deleteFile($filePath): bool
    {
        try{
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }catch (\Exception $e){
            return false;
        }
    }
}