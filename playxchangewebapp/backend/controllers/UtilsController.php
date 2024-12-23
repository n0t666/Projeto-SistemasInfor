<?php

namespace backend\controllers;

use app\mosquitto\phpMQTT;
use Yii;
use yii\web\Controller;

class UtilsController extends Controller
{

    public static function deleteFile($filePath): bool
    {
        try {
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /*
     *
     *  Função retirada de: https://gist.github.com/RadGH/84edff0cc81e6326029c
     *
     */
    public static function number_format_short($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }

    public static function publishMosquitto($topic, $msg)
    {
        if (empty($topic) || empty($msg)) {
            return;
        }

        $server = 'test.mosquitto.org';
        $port = 1884;
        $username = '';
        $password = '';
        $client_id = 'phpMQTT-publisher';


        $mqtt = new \Bluerhinos\phpMQTT($server, $port, $client_id);


        try {
            if ($mqtt->connect(true, NULL, $username, $password)) {
                $mqtt->publish($topic, $msg, );
                $mqtt->close();
            }
        } catch (\Exception $e) {
            $mqtt->close();
            return;
        }
    }

    public static function uploadBase64($alias, $base64){
        $imageData = base64_decode($base64);
        $path = Yii::getAlias($alias);
        $filename = Yii::$app->getSecurity()->generateRandomString() . '.jpeg';
        $filePath = $path . DIRECTORY_SEPARATOR . $filename;

        if (file_put_contents($filePath, $imageData)) {
            return $filename;
        }

        return false;
    }



}