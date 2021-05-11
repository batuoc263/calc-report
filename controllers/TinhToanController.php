<?php

namespace app\controllers;

use app\models\DmTinhtoan;
use app\models\DmTinhtoanSearch;
use Yii;
class TinhToanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new DmTinhtoanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionXacDinhApLucDuoiDayMongHinhChuNhat()
    {
        $dmtt = DmTinhtoan::findOne(['id' => 1]);
        $searchModel = new DmTinhtoanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $filePath = '';

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            // Trọng lượng bản thân của móng và đất:
            $G = round($input["varGamma"] * $input["varB"] * $input["varL"] * $input["varHd"], 1);
            // Tải trọng thẳng đứng có tính đến trọng lượng bản thân của móng và đất:
            $N = $input['varN'] + $G;
            
            // Diện tích đáy móng:
            $A = round($input['varB'] * $input['varL'], 3);
            
            // Monmen kháng uốn:
            $W_y = round((($input['varB'] * pow($input['varL'], 2)) / 6), 3);
            $W_x = round((($input['varL'] * pow($input['varB'], 2)) / 6), 3);

            // Monmen uốn tại đáy móng:
            $M_x = $input['varMx'] + $input['varQy'] * $input['varHm'];
            $M_y = $input['varMy'] + $input['varQx'] * $input['varHm'];

            // Kiểm tra độ lệch tâm:
            $e_x = round($M_y / $N, 4); $half_l = $input['varL'] / 2;
            if ($e_x < $half_l) {
                $kl_e_x = 'Thỏa';
                $compare1 = "<";
            } elseif ($e_x == $half_l) {
                $kl_e_x = 'Tăng chiều dài móng';
                $compare1 = "=";
            } else {
                $kl_e_x = 'Tăng chiều dài móng';
                $compare1 = ">";
            }
            
            $e_y = round($M_x / $N, 4); $half_b = $input['varB'] / 2;
            if ($e_y < $half_b) {
                $kl_e_y = 'Thỏa';
                $compare2 = "<";
            } elseif ($e_y == $half_b) {
                $kl_e_x = 'Tăng chiều rộng móng';
                $compare2 = "=";
            } else {
                $kl_e_x = 'Tăng chiều rộng móng';
                $compare2 = ">";
            }

            if (($e_x < $half_l) && ($e_y < $half_b)) {
                $templateFile = 'file-tinh-toan/sample/01.docx';
            } else {
                $templateFile = 'file-tinh-toan/sample/01_fail.docx';
            }
            

            // Ứng suất tại các góc của đáy móng:
            $sigma1 = round(($N / $A) + ($M_y / $W_y) + ($M_x / $W_x), 1);
            $sigma2 = round(($N / $A) + ($M_y / $W_y) - ($M_x / $W_x), 1);
            $sigma3 = round(($N / $A) - ($M_y / $W_y) + ($M_x / $W_x), 1);
            $sigma4 = round(($N / $A) - ($M_y / $W_y) - ($M_x / $W_x), 1);

            
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    'varGamma' => $input["varGamma"],
                    'varB' => $input["varB"],
                    'varL'=> $input["varL"],
                    'varHd'=> $input["varHd"],
                    'G'=> $G,
                    'varN'=> $input["varN"],
                    'A'=> $A,
                    'W_x'=> $W_x,
                    'W_y'=> $W_y,
                    'M_x'=> $M_x,
                    'M_y'=> $M_y,
                    'varMx' => $input["varMx"],
                    'varMy' => $input["varMy"],
                    'varQx' => $input["varQx"],
                    'varQy' => $input["varQy"],
                    'varHm' => $input["varHm"],
                    'e_x' => $e_x,
                    'e_y' => $e_y,
                    'half_l' => $half_l,
                    'half_b' => $half_b,
                    'sigma1' => $sigma1,
                    'sigma2' => $sigma2,
                    'sigma3' => $sigma3,
                    'sigma4' => $sigma4,
                    'kl_e_x' => $kl_e_x,
                    'kl_e_y' => $kl_e_y,
                    'N' => $N,
                    'ss1' => $compare1,
                    'ss2' => $compare2,

                ]
            );

            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat_'.$timestamp.'.docx';
            $fileStorage = 'file-tinh-toan/output/'.$filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/'.$fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat', [
            'dmtt' => $dmtt,
            'filePath' => $filePath,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionXacDinhApLucDuoiDayMongTron()
    {
        $dmtt = DmTinhtoan::findOne(['id' => 2]);
        $searchModel = new DmTinhtoanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            // Diện tích đáy móng (A) và momen kháng uốn (W):
            $A = round( (PI()*pow($input["varD"], 2)) / 4, 3);

            $W = round( (PI()*pow($input["varD"], 3)) / 32, 3);

            // Trọng lượng bản thân của móng và đất:
            $G = $input['varGamma'] * $A * $input['varHd'];
            
            // Tải trọng thẳng đứng có tính đến trọng lượng bản thân của móng và đất:
            $N = round($input['varN'] + $G, 3);


            // Monmen uốn tại đáy móng:
            $M_x = $input['varMx'] + $input['varQy'] * $input['varHm'];
            $M_y = $input['varMy'] + $input['varQx'] * $input['varHm'];
            $M = round(sqrt(pow($M_x, 2) + pow($M_y, 2)), 3);

            // Kiểm tra độ lệch tâm:
            $e = round($M / $N, 3);  $halfD = $input['varD'] / 2;
            if ($e < $halfD) {
                $kl = 'Thỏa';
                $ss = '<';
                $templateFile = 'file-tinh-toan/sample/02.docx';
            } else {
                $kl = 'Tăng đường kính móng';
                $ss = '>';
                $templateFile = 'file-tinh-toan/sample/02_fail.docx';
            }
            
            

            // Ứng suất tại các góc của đáy móng:
            $sigma_max = round(($N / $A) + ($M / $W) , 1);
            $sigma_min = round(($N / $A) - ($M / $W) , 1);


            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    'varGamma' => $input["varGamma"],
                    'varD'=> $input["varD"],
                    'varHd'=> $input["varHd"],
                    'G'=> $G,
                    'varN'=> $input["varN"],
                    'A'=> $A,
                    'W'=> $W,
                    'M'=> $M,
                    'M_x'=> $M_x,
                    'M_y'=> $M_y,
                    'varMx' => $input["varMx"],
                    'varMy' => $input["varMy"],
                    'varQx' => $input["varQx"],
                    'varQy' => $input["varQy"],
                    'varHm' => $input["varHm"],
                    'e' => $e,
                    'halfD' => $halfD,
                    'sigma_min' => $sigma_min,
                    'sigma_max' => $sigma_max,
                    'kl' => $kl,
                    'N' => $N,
                    'ss' => $ss

                ]
            );

            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-ap-luc-duoi-day-mong-tron_'.$timestamp.'.docx';
            $fileStorage = 'file-tinh-toan/output/'.$filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/'.$fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
         }
        return $this->render('xac-dinh-ap-luc-duoi-day-mong-tron', [
            'dmtt' => $dmtt,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
