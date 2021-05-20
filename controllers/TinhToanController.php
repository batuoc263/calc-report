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

    public function actionResult($filePath)
    {
        return $this->render('result', [
            'filePath' => $filePath
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

    public function actionXacDinhApLucTinhToanTacDungLenNen()
    {
        $dmtt = DmTinhtoan::findOne(['id' => 3]);
        $searchModel = new DmTinhtoanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            //khối lượng thể tích của nước
            $GammaW = 10;

            // hệ số e
            $e = 0.7;

            //  trị tính toán trung bình của trọng lượng thể tích của kết cấu sàn hầm
            $Gammakc = 25;

            // góc ma sát trong
            $phi = deg2rad($input["varPhiII"]);
            $cotangPhi =  1/tan($phi);
            
            if($input["varPhiII"] == 0) {
                $cotangPhi = 0;
            }
            
            // Hệ số không thứ nguyên
            $A = round( (0.25 * PI()) / ($cotangPhi + $phi - PI()/2), 2); 
            $B = round( (PI() / ($cotangPhi + $phi - PI()/2)) + 1, 2);
            $D = round( (PI() * $cotangPhi) / ($cotangPhi + $phi - PI()/2), 2);
            

            // chiều sâu đặt móng tính đổi kể từ nền tầng hầm bên trong nhà có tầng hầm 
            $Htd = round( $input["varH1"] + $input['varH2'] * ($Gammakc / $input["varGamma1"]), 2 );

            //trọng lượng thể tích trung bình nằm dưới đáy móng
            $Gamma2 = $input['varGamma2'];

            // chiều sâu đến tầng hầm
            $H0 = $input["varH"] - $Htd;

            if ($input['check_day_noi'] =='no' && $input['check_tang_ham'] == 'no') {
                $H0  =  0;
                $templateFile = "file-tinh-toan/sample/04_TH1.docx";
                
            } elseif ($input['check_day_noi'] =='no' && $input['check_tang_ham'] == 'yes') {
                $templateFile = "file-tinh-toan/sample/04_TH2.docx";
            } elseif ($input['check_day_noi'] =='yes' && $input['check_tang_ham'] == 'no') {
                $Gamma2 = 10;
                $H0  = 0;
                $Gamma2 = ($input["varGammaS"] - $GammaW) / (1+$e);
                $templateFile = "file-tinh-toan/sample/04_TH3.docx";
            } else {
                $templateFile = "file-tinh-toan/sample/04_TH4.docx";
            }

            // Áp lực tính toán tác dụng lên nền
            $R = round( ( ($input['varM1'] * $input['varM2']) / $input['varKtc'] ) * ($A * $input['varB'] * $Gamma2 + $B * $input['varH'] * $input['varGamma1'] +$D * $input['varCII'] - $input['varGamma1']*$H0 ), 2 );


            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    "varPhiII"=> $input["varPhiII"],
                    "varCII"=> $input["varCII"],
                    "varGamma1"=> $input["varGamma1"],
                    "varGamma2"=> $Gamma2,
                   "varGammaS"=>$input["varGammaS"],
                   "varE"=> $input["varE"],
                    "varH"=> $input["varH"],
                    "varB"=> $input["varB"],
                    "varH1"=> $input["varH1"],
                    "varH2"=> $input["varH2"],
                    "varM1"=> $input["varM1"],
                    "varM2"=> $input["varM2"],
                   "varKtc"=> $input["varKtc"],
                    "A"=> $A,
                    "B" => $B,
                    "D" => $D,
                    "R"=> $R,
                    "H0" => $H0,
                    "Htd" => $Htd,
                    "Gammakc" => $Gammakc,
                    "GammaW" => $GammaW,
                    "e" => $e,

                ]
            );
            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-ap-luc-tinh-toan-tac-dung-len-nen_'.$timestamp.'.docx';
            $fileStorage = 'file-tinh-toan/output/'.$filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/'.$fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
         }
        return $this->render('xac-dinh-ap-luc-tinh-toan-tac-dung-len-nen', [
            'dmtt' => $dmtt,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    public function actionXacDinhSucChiuTaiCocChong()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/xac-dinh-suc-chiu-tai-coc-chong']);
        $searchModel = new DmTinhtoanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $capdoben = [
            'B10' => [
                'Rb' => 6000,
                'Rbt' => 560,
                'E' => 1.90E+07
            ],
            'B15' => [
                'Rb' => 8500,
                'Rbt' => 750,
                'E' => 2.40E+07
            ],
            'B20' => [
                'Rb' => 11500,
                'Rbt' => 900,
                'E' => 2.75E+07
            ],
            'B25' => [
                'Rb' => 14500,
                'Rbt' => 1050,
                'E' => 3.00E+07
            ],
            'B30' => [
                'Rb' => 17000,
                'Rbt' => 1150,
                'E' => 3.25E+07
            ],
            'B35' => [
                'Rb' => 19000,
                'Rbt' => 1300,
                'E' => 3.45E+07
            ],
            'B40' => [
                'Rb' => 22000,
                'Rbt' => 1400,
                'E' => 3.60E+07
            ],
            'B45' => [
                'Rb' => 25000,
                'Rbt' => 1500,
                'E' => 3.70E+07
            ],
            'B50' => [
                'Rb' => 27500,
                'Rbt' => 1600,
                'E' => 3.80E+07
            ],
            'B55' => [
                'Rb' => 30000,
                'Rbt' => 1700,
                'E' => 3.90E+07
            ],
            'B60' => [
                'Rb' => 33000,
                'Rbt' => 1800,
                'E' => 3.95E+07
            ],
        ];

        $loaithep = [
            'SD390' => [
                'Rs' => 3.45E+05,
                'Rsc' => 3.45E+05,
                'Es' => 2.00E+08
            ],
            'SD490' => [
                'Rs' => 4.21E+05,
                'Rsc' => 4.21E+05,
                'Es' => 1.90E+08
            ],
            'SR235' => [
                'Rs' => 2.14E+05,
                'Rsc' => 2.14E+05,
                'Es' => 2.10E+08
            ],
            'SR295' => [
                'Rs' => 2.68E+05,
                'Rsc' => 2.68E+05,
                'Es' => 2.10E+08
            ],
            'CB240-T' => [
                'Rs' => 2.28E+05,
                'Rsc' => 2.28E+05,
                'Es' => 2.10E+08
            ],
            'CB300-T' => [
                'Rs' => 2.85E+05,
                'Rsc' => 2.85E+05,
                'Es' => 2.10E+08
            ],
            'CB400-V' => [
                'Rs' => 3.73E+05,
                'Rsc' => 3.73E+05,
                'Es' => 2.00E+08
            ],
            'CB500-V' => [
                'Rs' => 4.34E+05,
                'Rsc' => 4.50E+05,
                'Es' => 1.90E+08
            ],
            'CI, A-I' => [
                'Rs' => 2.25E+05,
                'Rsc' => 2.25E+05,
                'Es' => 2.10E+08
            ],
            'CII, A-II' => [
                'Rs' => 2.80E+05,
                'Rsc' => 2.80E+05,
                'Es' => 2.10E+08
            ],
            'CIII, A-III' => [
                'Rs' => 3.65E+05,
                'Rsc' => 3.65E+05,
                'Es' => 2.00E+08
            ],
            'CIV, A-IV' => [
                'Rs' => 5.10E+05,
                'Rsc' => 4.50E+05,
                'Es' => 1.90E+08
            ],
            'A-V' => [
                'Rs' => 6.80E+05,
                'Rsc' => 5.00E+05,
                'Es' => 1.90E+08
            ],
            'A-VI' => [
                'Rs' => 8.15E+05,
                'Rsc' => 5.00E+05,
                'Es' => 1.90E+08
            ],
            'AT-VII' => [
                'Rs' => 9.80E+05,
                'Rsc' => 5.00E+05,
                'Es' => 1.90E+08
            ],
            'A-IIIB' => [
                'Rs' => 4.50E+05,
                'Rsc' => 2.00E+05,
                'Es' => 1.80E+08
            ],
        ];

        // Sample 08
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            

            $templateFile = 'file-tinh-toan/sample/08.docx';
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    // 'varGamma' => $input["varGamma"],
                    

                ]
            );

            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-suc-chiu-tai-coc-chong_'.$timestamp.'.docx';
            $fileStorage = 'file-tinh-toan/output/'.$filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/'.$fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
         }
        return $this->render('xac-dinh-suc-chiu-tai-coc-chong', [
            'dmtt' => $dmtt,
            'cap_do_ben_arr' => $capdoben,
            'cap_do_ben_json' => json_encode($capdoben),
            'loai_thep_arr' => $loaithep,
            'loai_thep_json' => json_encode($loaithep),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
