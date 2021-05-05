<?php

namespace app\controllers;

use app\models\Files;

class DmtcvnController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $files = Files::findAll(['state' => 1]);
        return $this->render('index', ['files' => $files]);
    }

}
