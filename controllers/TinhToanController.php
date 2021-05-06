<?php

namespace app\controllers;

class TinhToanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionXacDinhApLucDuoiDayMongHinhChuNhat()
    {
        return $this->render('xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat');
    }

}
