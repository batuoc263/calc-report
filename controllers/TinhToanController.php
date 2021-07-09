<?php

namespace app\controllers;

use app\models\DmNhomBai;
use app\models\DmTinhtoan;
use app\models\DmTinhtoanSearch;
use Yii;

class TinhToanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }
        return $this->render('index', [
            'menu' => $menu,
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
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat']);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }
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
            $e_x = round($M_y / $N, 4);
            $half_l = $input['varL'] / 2;
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

            $e_y = round($M_x / $N, 4);
            $half_b = $input['varB'] / 2;
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
                $templateFile = './file-tinh-toan/sample/01.docx';
            } else {
                $templateFile = './file-tinh-toan/sample/01_fail.docx';
            }


            // Ứng suất tại các góc của đáy móng:
            $sigma1 = round(($N / $A) + ($M_y / $W_y) + ($M_x / $W_x), 1);
            $sigma2 = round(($N / $A) + ($M_y / $W_y) - ($M_x / $W_x), 1);
            $sigma3 = round(($N / $A) - ($M_y / $W_y) + ($M_x / $W_x), 1);
            $sigma4 = round(($N / $A) - ($M_y / $W_y) - ($M_x / $W_x), 1);


            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    'varGamma' => $input["varGamma"],
                    'varB' => $input["varB"],
                    'varL' => $input["varL"],
                    'varHd' => $input["varHd"],
                    'G' => $G,
                    'varN' => $input["varN"],
                    'A' => $A,
                    'W_x' => $W_x,
                    'W_y' => $W_y,
                    'M_x' => $M_x,
                    'M_y' => $M_y,
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
            $filename = 'xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat', [
            'dmtt' => $dmtt,
            'filePath' => $filePath,
            'menu' => $menu,
        ]);
    }

    public function actionXacDinhApLucDuoiDayMongTron()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/xac-dinh-ap-luc-duoi-day-mong-tron']);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            // Diện tích đáy móng (A) và momen kháng uốn (W):
            $A = round((PI() * pow($input["varD"], 2)) / 4, 3);

            $W = round((PI() * pow($input["varD"], 3)) / 32, 3);

            // Trọng lượng bản thân của móng và đất:
            $G = $input['varGamma'] * $A * $input['varHd'];

            // Tải trọng thẳng đứng có tính đến trọng lượng bản thân của móng và đất:
            $N = round($input['varN'] + $G, 3);


            // Monmen uốn tại đáy móng:
            $M_x = $input['varMx'] + $input['varQy'] * $input['varHm'];
            $M_y = $input['varMy'] + $input['varQx'] * $input['varHm'];
            $M = round(sqrt(pow($M_x, 2) + pow($M_y, 2)), 3);

            // Kiểm tra độ lệch tâm:
            $e = round($M / $N, 3);
            $halfD = $input['varD'] / 2;
            if ($e < $halfD) {
                $kl = 'Thỏa';
                $ss = '<';
                $templateFile = './file-tinh-toan/sample/02.docx';
            } else {
                $kl = 'Tăng đường kính móng';
                $ss = '>';
                $templateFile = './file-tinh-toan/sample/02_fail.docx';
            }



            // Ứng suất tại các góc của đáy móng:
            $sigma_max = round(($N / $A) + ($M / $W), 1);
            $sigma_min = round(($N / $A) - ($M / $W), 1);


            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    'varGamma' => $input["varGamma"],
                    'varD' => $input["varD"],
                    'varHd' => $input["varHd"],
                    'G' => $G,
                    'varN' => $input["varN"],
                    'A' => $A,
                    'W' => $W,
                    'M' => $M,
                    'M_x' => $M_x,
                    'M_y' => $M_y,
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
            $filename = 'xac-dinh-ap-luc-duoi-day-mong-tron_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('xac-dinh-ap-luc-duoi-day-mong-tron', [
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }

    public function actionXacDinhApLucTinhToanTacDungLenNen()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/xac-dinh-ap-luc-tinh-toan-tac-dung-len-nen']);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            //khối lượng thể tích của nước
            $GammaW = 10;

            //  trị tính toán trung bình của trọng lượng thể tích của kết cấu sàn hầm
            $Gammakc = 25;

            // góc ma sát trong
            $phi = deg2rad($input["varPhiII"]);
            $cotangPhi =  1 / tan($phi);

            if ($input["varPhiII"] == 0) {
                $cotangPhi = 0;
            }

            // Hệ số không thứ nguyên
            $A = round((0.25 * PI()) / ($cotangPhi + $phi - PI() / 2), 2);
            $B = round((PI() / ($cotangPhi + $phi - PI() / 2)) + 1, 2);
            $D = round((PI() * $cotangPhi) / ($cotangPhi + $phi - PI() / 2), 2);


            // chiều sâu đặt móng tính đổi kể từ nền tầng hầm bên trong nhà có tầng hầm 
            $Htd = round($input["varH1"] + $input['varH2'] * ($Gammakc / $input["varGamma1"]), 2);

            //trọng lượng thể tích trung bình nằm dưới đáy móng
            $Gamma2 = $input['varGamma2'];

            // chiều sâu đến tầng hầm
            $H0 = $input["varH"] - $Htd;

            if ($input['check_day_noi'] == 'no' && $input['check_tang_ham'] == 'no') {
                $H0  =  0;
                $templateFile = "./file-tinh-toan/sample/04_TH1.docx";
            } elseif ($input['check_day_noi'] == 'no' && $input['check_tang_ham'] == 'yes') {
                $templateFile = "./file-tinh-toan/sample/04_TH2.docx";
            } elseif ($input['check_day_noi'] == 'yes' && $input['check_tang_ham'] == 'no') {
                $Gamma2 = 10;
                $H0  = 0;
                $Gamma2 = round(($input["varGammaS"] - $GammaW) / (1 + $input['varE']), 2);
                $templateFile = "./file-tinh-toan/sample/04_TH3.docx";
            } else {
                $Gamma2 = round(($input["varGammaS"] - $GammaW) / (1 + $input['varE']), 2);
                $templateFile = "./file-tinh-toan/sample/04_TH4.docx";
            }

            // Áp lực tính toán tác dụng lên nền
            $R = round((($input['varM1'] * $input['varM2']) / $input['varKtc']) * ($A * $input['varB'] * $Gamma2 + $B * $input['varH'] * $input['varGamma1'] + $D * $input['varCII'] - $input['varGamma1'] * $H0), 2);


            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    "varPhiII" => $input["varPhiII"],
                    "varCII" => $input["varCII"],
                    "varGamma1" => $input["varGamma1"],
                    "varGamma2" => $input["varGamma2"],
                    "varGammaS" => $input["varGammaS"],
                    "varE" => $input["varE"],
                    "varH" => $input["varH"],
                    "varB" => $input["varB"],
                    "varH1" => $input["varH1"],
                    "varH2" => $input["varH2"],
                    "varM1" => $input["varM1"],
                    "varM2" => $input["varM2"],
                    "varKtc" => $input["varKtc"],
                    "A" => $A,
                    "B" => $B,
                    "D" => $D,
                    "R" => $R,
                    "H0" => $H0,
                    "Htd" => $Htd,
                    "Gammakc" => $Gammakc,
                    "GammaW" => $GammaW,
                    "Gamma2" => $Gamma2

                ]
            );
            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-ap-luc-tinh-toan-tac-dung-len-nen_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('xac-dinh-ap-luc-tinh-toan-tac-dung-len-nen', [
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }


    public function actionXacDinhSucChiuTaiCocChong()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/xac-dinh-suc-chiu-tai-coc-chong']);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

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

        $chisochatluongda = [
            [
                'RQD' => [
                    'max' => 100,
                    'min' => 90
                ],
                'Ks' => [
                    'max' => 1.00,
                    'min' => 1.00
                ]
            ],
            [
                'RQD' => [
                    'max' => 90,
                    'min' => 75
                ],
                'Ks' => [
                    'max' => 1.00,
                    'min' => 0.60
                ]
            ],
            [
                'RQD' => [
                    'max' => 75,
                    'min' => 50
                ],
                'Ks' => [
                    'max' => 0.60,
                    'min' => 0.32
                ]
            ],
            [
                'RQD' => [
                    'max' => 50,
                    'min' => 25
                ],
                'Ks' => [
                    'max' => 0.32,
                    'min' => 0.15
                ]
            ],
            [
                'RQD' => [
                    'max' => 25,
                    'min' => 0
                ],
                'Ks' => [
                    'max' => 0.15,
                    'min' => 0.05
                ]
            ],
        ];

        $loaicoc_arr = [
            1 => 'Khoan nhồi',
            2 => 'Đóng - ép'
        ];
        $tietdiencoc_arr = [
            1 => 'Tròn',
            2 => 'Vuông',
            3 => 'Ống'
        ];

        $gammaC = 1;

        // Sample 08
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            if ($input['varRQD'] > 100 || $input['varRQD'] < 0) {
                echo "Chỉ số chất lượng đá không phù hợp";
                return;
            } else {
                foreach ($chisochatluongda as $key => $chiso) {
                    if ($input['varRQD'] < $chiso['RQD']['max'] && $input['varRQD'] >= $chiso['RQD']['min']) {
                        $Ks = (($input['varRQD'] - $chiso['RQD']['min']) / ($chiso['RQD']['max'] - $chiso['RQD']['min'])) * ($chiso['Ks']['max'] - $chiso['Ks']['min']) + $chiso['Ks']['min'];
                        break;
                    }
                }
            }

            if ($input['varLd'] < 0.5) {
                $qb = $input['varRcn'] * $Ks / $input['varGammaG'];
                $templateFile = './file-tinh-toan/sample/08_TH2.docx';
            } else {
                $temp = (1 + 0.4 * ($input['varLd'] / $input['varDf']));
                $temp > 3 ? $temp = 3 : $temp = $temp;
                $qb = ($input['varRcn'] * $Ks / $input['varGammaG']) * $temp;
                $templateFile = './file-tinh-toan/sample/08_TH3.docx';
            }

            if ($input['loai_coc'] == 2) {
                $templateFile = './file-tinh-toan/sample/08_TH1.docx';
            }


            if ($qb > 20) {
                $qbFinal = 20;
            } else {
                $qbFinal = $qb;
            }

            $Rcu = $gammaC * $qbFinal * 1000 * $input['varA'];

            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\01.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    'loai_coc' => $loaicoc_arr[$input['loai_coc']],
                    'tiet_dien_coc' => $tietdiencoc_arr[$input['tiet_dien_coc']],
                    'varAD' => $input['varAD'],
                    'varD' => $input['varD'],
                    'varLd' => $input['varLd'],
                    'varDf' => $input['varDf'],
                    'cap_do_ben' => $input['cap_do_ben'],
                    'loai_thep' => $input['loai_thep'],
                    'varN' => $input['varN'],
                    'varDt' => $input['varDt'],
                    'varAs' => $input['varAs'],
                    'varAb' => $input['varAb'],
                    'varRsc' => $input['varRsc'],
                    'varRb' => $input['varRb'],
                    'varGammaC' => $input['varGammaC'],
                    'varPhi' => $input['varPhi'],
                    'varGammaCb' => $input['varGammaCb'],
                    'varGammaCbsub' => $input['varGammaCbsub'],
                    'varGammaS' => $input['varGammaS'],
                    'varRvl' => $input['varRvl'],
                    'varGammaG' => $input['varGammaG'],
                    'gammaC' => $gammaC,
                    'varRcn' => $input['varRcn'],
                    'varRQD' => $input['varRQD'],
                    'varA' => $input['varA'],
                    'Ks' => round($Ks, 2),
                    'qb' => round($qb, 2),
                    'qbFinal' => round($qbFinal, 2),
                    'Rcu' => round($Rcu, 0),
                ]
            );

            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-suc-chiu-tai-coc-chong_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('xac-dinh-suc-chiu-tai-coc-chong', [
            'dmtt' => $dmtt,
            'loaicoc_arr' => $loaicoc_arr,
            'tietdiencoc_arr' => $tietdiencoc_arr,
            'cap_do_ben_arr' => $capdoben,
            'cap_do_ben_json' => json_encode($capdoben),
            'loai_thep_arr' => $loaithep,
            'loai_thep_json' => json_encode($loaithep),
            'menu' => $menu,
        ]);
    }

    public function actionXacDinhTaiTrongTacDungLenDauCoc()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => "/tinh-toan/xac-dinh-tai-trong-tac-dung-len-dau-coc"]);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            $N = $input["varN"];

            $sumX = 0;
            $sumY = 0;
            $sumX2 = 0;
            $sumY2 = 0;
            foreach ($input['list'] as $item) {
                $sumX += $item[0];
                $sumY += $item[1];
            }

            $xC = $sumX / $input["lineNo"];
            $yC = $sumY / $input["lineNo"];
            $textSumX = "";
            $textSumY = "";

            $textSumX2 = "";
            $textSumY2 = "";

            // $fa_euro = utf8(html_entity_decode('&#xf153;', 0, 'UTF-8'));
            // $section->addText(utf8($fa_euro));

            foreach ($input['list'] as $key => $item) {
                $xp = $item[0] - $xC;
                $yp = $item[1] - $yC;
                array_push($input['list'][$key], $xp);
                array_push($input['list'][$key], $yp);
                $sumX2 += pow($xp, 2);
                $sumY2 += pow($yp, 2);
                if ($key >= 1) {
                    $textSumX .= "+ (" . $item[0] . ") ";
                    $textSumY .= "+ (" . $item[1] . ") ";
                    $textSumX2 .= "+ (" . $xp . ")2 " . "&#178;" . "";
                    $textSumY2 .= "+ (" . $yp . ")2 ";
                } else {
                    $textSumX .= "(" . $item[0] . ") ";
                    $textSumY .= "(" . $item[1] . ") ";
                    $textSumX2 .= "(" . $xp . ")2 ";
                    $textSumY2 .= "(" . $yp . ")2 ";
                }
            }

            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\06.docx');
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $inline = new \PhpOffice\PhpWord\Element\TextRun();
            $inline->addText("2", array('italic' => true, 'padding-bottom' => '10px'));
            $templateProcessor->setComplexValue('textSumX2', $inline);

            // $templateProcessor->setValues(
            //     [
            //         "textSumX2"=> $textSumX2,

            //     ]
            // );
            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-tai-trong-tac-dung-len-dau-coc_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('xac-dinh-tai-trong-tac-dung-len-dau-coc', [
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }

    public function actionTinhToanDoLunCocDon()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => "/tinh-toan/tinh-toan-do-lun-coc-don"]);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        $coctreodon_arr = [
            1 => 'Không mở rộng mũi',
            2 => 'Có mở rộng mũi'
        ];
        $tietdiencoc_arr = [
            1 => 'Tròn',
            2 => 'Vuông',
            3 => 'Ống'
        ];

        // Sample 15
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            if ($input['coc_treo_don'] == 1) {
                //Cong thuc 7 -> 12
                $v = ($input['varV1'] + $input['varV2']) / 2; //(7)

                $kv = 2.82 - 3.78 * $v + 2.18 * pow($v, 2); //(8)
                $kv1 = 2.82 - 3.78 * $input['varV1'] + 2.18 * pow($input['varV1'], 2); //(10)

                $G1 = $input['varE1'] / (2 * (1 + $input['varV1'])); // (11)
                $G2 = $input['varE2'] / (2 * (1 + $input['varV2'])); // (12)
                //CT 5 
                $chi = ($input['varE'] * $input['varA']) / ($G1 * pow($input['varL'], 2));

                //CT 6
                $lamda1 = (2.12 * pow($chi, 3 / 4)) / (1 + 2.12 * pow($chi, 3 / 4));

                //CT 3 
                $betasub = 0.17 * log(($kv * $G1 * $input['varL']) / ($G2 * $input['varD']));

                //CT 4
                $alphasub = 0.17 * log($kv1 * $input['varL'] / $input['varD']);

                //CT 2
                $beta = $betasub / $lamda1 + (1 - $betasub / $alphasub) / $chi;

                //CT 1 
                $s = $beta * $input['varN'] / ($G1 * $input['varL']);
                $smm = $s * 1000;
                $templateFile = './file-tinh-toan/sample/15_TH1.docx';
            } else {
                // CT 2
                $G2 = $input['varE2'] / (2 * (1 + $input['varV2']));

                //CT 1
                $s  = ((0.22 * $input['varN']) / ($G2 * $input['varDb'])) + ($input['varN'] * $input['varL']) / ($input['varE'] * $input['varA']);
                $smm = $s * 1000;
                $templateFile = './file-tinh-toan/sample/15_TH2.docx';
            }

            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\15.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);


            $templateProcessor->setValues(
                [
                    "varN" => $input['varN'],
                    "coc_treo_don" => $coctreodon_arr[$input['coc_treo_don']],
                    "tiet_dien_coc" => $tietdiencoc_arr[$input['tiet_dien_coc']],
                    "varD" => $input['varD'],
                    "varDt" => $input['varDt'],
                    "varDb" => $input['varDb'],
                    "varL" => $input['varL'],
                    "varE" => $input['varE'],
                    "varE1" => $input['varE1'],
                    "varE2" => $input['varE2'],
                    "varV1" => $input['varV1'],
                    "varV2" => $input['varV2'],
                    "varA" => round($input['varA'], 3),
                ]
            );
            if ($input['coc_treo_don'] == 1) {
                $templateProcessor->setValues(
                    [
                        "v" => $v,
                        "kv" => round($kv, 2),
                        "kv1" => round($kv1, 2),
                        "G1" => round($G1, 2),
                        "G2" => round($G2, 2),
                        "chi" => round($chi, 1),
                        "lamda1" => round($lamda1, 3),
                        "betasub" => round($betasub, 3),
                        "alphasub" => round($alphasub, 3),
                        "beta" => round($beta, 3),
                        "s" => round($s, 4),
                        "smm" => round($smm, 1),
                    ]
                );
            } else {
                $templateProcessor->setValues(
                    [
                        "G2" => round($G2, 2),
                        "s" => round($s, 4),
                        "smm" => round($smm, 1),
                    ]
                );
            }

            $timestamp = date('Ymd_His');
            $filename = 'tinh-toan-do-lun-coc-don_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('tinh-toan-do-lun-coc-don', [
            'coctreodon_arr' => $coctreodon_arr,
            'tietdiencoc_arr' => $tietdiencoc_arr,
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }

    public function actionXacDinhSucChiuTaiCocTheoDoChoiSa()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => "/tinh-toan/xac-dinh-suc-chiu-tai-coc-theo-do-choi-sa"]);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        $loaibua_arr = [
            1 => "Búa treo hay búa tác dụng đơn",
            2 => "Búa diezen dạng ống",
            3 => "Búa diezen dạng cân",
            4 => "Búa diezen khi đóng vỗ kiểm tra cho quả búa rơi tự do không tiếp liệu"
        ];
        $tietdiencoc_arr = [
            2 => 'Vuông',
            1 => 'Tròn',
            3 => 'Ống'
        ];

        // Sample 13_14
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            $h_kytu = '';
            $h_p1 = '';
            $h_p2 = '';
            switch ($input['loaibua']) {
                case '1':
                    $Ed = $input['varG'] * $input['varH'];
                    $ct_Ed = "G × H = " . $input['varG'] . " × " . $input['varH'];
                    break;
                case '2':
                    $Ed = 0.9 * $input['varG'] * $input['varH'];
                    $ct_Ed = "0.9 × G × H = 0.9 × " . $input['varG'] . " × " . $input['varH'];
                    break;
                case '3':
                    $Ed = 0.4 * $input['varG'] * $input['varH'];
                    $ct_Ed = "0.4 × G × H = 0.4 × " . $input['varG'] . " × " . $input['varH'];
                    break;
                case '4':
                    $Ed = $input['varG'] * ($input['varH'] - $input['varh']);
                    $ct_Ed = "G × (H - h) = " . $input['varG'] . " × (" . $input['varH'] . " - " . $input['varh'] . ")";
                    $h_kytu = 'h';
                    $h_p1 = '- chiều cao bật lần thứ nhất của quả búa diezen,';
                    $h_p2 = '= ' . $input['varh'] . ' m.';
                    break;
            }

            if ($input['varSa'] < 0.002) {
                $np = 0.00025;
                $nf = 0.025;

                $g = 9.81; //gia tốc trọng trường
                $theta = 1 / 4 * ($np / $input['varA'] + $nf / $input['varAf']) * $input['varm4'] / ($input['varm4'] + $input['varm2']) * sqrt(2 * $g * ($input['varH'] - $input['varh']));


                $Rcu = 1 / (2 * $theta) * ((2 * $input['varSa'] + $input['varSel']) / ($input['varSa'] + $input['varSel'])) * (sqrt(1 + (8 * $Ed * ($input['varSa'] + $input['varSel'])) / pow((2 * $input['varSa'] + $input['varSel']), 2) * $input['varm4'] / ($input['varm4'] + $input['varm2']) * $theta) - 1);
                $Rcu = round($Rcu, 1);

                $templateFile = './file-tinh-toan/sample/13_14_TH1.docx';
            } else {
                $Rcu = $input['varEta'] * $input['varA'] * $input['varM'] / 2 * (sqrt(1 + 4 * $Ed / ($input['varEta'] * $input['varA'] * $input['varSa']) * ($input['varm1'] + $input['varEpsilon_sqr'] * ($input['varm2'] + $input['varm3'])) / ($input['varm1'] + $input['varm2'] + $input['varm3'])) - 1);

                $Rcu = round($Rcu, 1);

                $templateFile = './file-tinh-toan/sample/13_14_TH2.docx';
            }

            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

            $templateProcessor->setValues(
                [
                    "tiet_dien_coc" => $tietdiencoc_arr[$input['tiet_dien_coc']],
                    "loaibua" => $loaibua_arr[$input["loaibua"]],
                    "varSa" => $input["varSa"],
                    "varSel" => $input["varSel"],
                    "varAD" => $input["varAD"],
                    "varD" => $input["varD"],
                    "varA" => $input["varA"],
                    "varAf" => $input["varAf"],
                    "varEta" => $input["varEta"],
                    "varM" => $input["varM"],
                    "varG" => $input["varG"],
                    "varH" => $input["varH"],
                    "varh" => $input["varh"],
                    "varm1" => $input["varm1"],
                    "varm2" => $input["varm2"],
                    "varm3" => $input["varm3"],
                    "varm4" => $input["varm4"],
                    "varEpsilon_sqr" => $input["varEpsilon_sqr"],
                    "Rcu" => $Rcu,
                    "Ed" => $Ed,
                    "ct_Ed" => $ct_Ed,
                    "h_kytu" => $h_kytu,
                    "h_p1" => $h_p1,
                    "h_p2" => $h_p2
                ]
            );
            if ($input['varSa'] < 0.002) {
                $templateProcessor->setValues(
                    [
                        "theta" => round($theta, 5),
                        "np" => $np,
                        "nf" => $nf,
                    ]
                );
            }

            $timestamp = date('Ymd_His');
            $filename = 'xac-dinh-suc-chiu-tai-coc-theo-do-choi-sa_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('xac-dinh-suc-chiu-tai-coc-theo-do-choi-sa', [
            'loaibua_arr' => $loaibua_arr,
            'tietdiencoc_arr' => $tietdiencoc_arr,
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }

    public function actionKiemTraUngSuatTaiMaiCuaLopDatYeu()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => "/tinh-toan/kiem-tra-ung-suat-tai-mai-cua-lop-dat-yeu"]);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }


        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            $varNII = $input['varNII'];
            $varPhiII = $input['varPhiII'];
            $varCII = $input['varCII'];
            $varGammaII = $input['varGammaII'];
            $varGammaIIPhay = $input['varGammaIIPhay'];
            $varGammaII2Phay = $input['varGammaII2Phay'];
            $varB = $input['varB'];
            $varL = $input['varL'];
            $varH = $input['varH'];
            $varZ = $input['varZ'];
            $varM1 = $input['varM1'];
            $varM2 = $input['varM2'];
            $varH1 = $input['varH1'];
            $varH2 = $input['varH2'];
            $varKtc = $input['varKtc'];
            $varM2 = $input['varM2'];
            $check_tang_ham = $input['check_tang_ham'];

            $gammatc = 25;
            $anpha = (2 / PI())  * (atan(($varB * $varL) / (2 * $varZ * sqrt(pow($varB, 2) + pow($varL, 2) + 4 * pow($varZ, 2))))    +  ((2 * $varB * $varL * $varZ * (pow($varB, 2) + pow($varL, 2) + 8 * pow($varZ, 2)))   /   ((pow($varB, 2) + 4 * pow($varZ, 2)) * (pow($varL, 2) + 4 * pow($varZ, 2)) * sqrt(pow($varB, 2) + pow($varL, 2) + 4 * pow($varZ, 2)))));


            $phi = deg2rad($varPhiII);
            $cotangPhi =  1 / tan($phi);

            if ($varPhiII == 0) {
                $cotangPhi = 0;
            }

            // Hệ số không thứ nguyên
            $A = round((0.25 * PI()) / ($cotangPhi + $phi - PI() / 2), 2);
            $B = round((PI() / ($cotangPhi + $phi - PI() / 2)) + 1, 2);
            $D = round((PI() * $cotangPhi) / ($cotangPhi + $phi - PI() / 2), 2);


            $a = 0.5 * ($varL - $varB);
            $p = round($varNII / ($varL * $varB), 2);
            $pd = round($varGammaIIPhay * $varH, 2);
            $po = $p - $pd;
            $m = round(2 * $varZ / $varB, 2);
            $n = round($varL / $varB, 2);
            $pdz = round($pd + $varGammaII2Phay * $varZ, 2);
            $poz = round($anpha * $po, 2);
            $sumb = $pdz + $poz;
            $Az = round($varNII / $poz, 2);
            $bz = round(sqrt($Az + pow($a, 2)) - $a, 2);
            $h0 = 0;
            $htd = 0;
            if ($check_tang_ham == 'no') {
                $templateFile = './file-tinh-toan/sample/21_TH1.docx';
            } else {
                $htd = round($varH1 + $varH2 * ($gammatc / $varGammaIIPhay), 2);
                $h0 = $varH - $htd;
                $templateFile = './file-tinh-toan/sample/21_TH2.docx';
            }


            $gammaIItb = round(($varGammaIIPhay * $varH + $varGammaII2Phay * $varZ) / ($varH + $varZ), 2);

            $R = round((($varM1 * $varM2) / $varKtc) * ($A * $bz * $varGammaII + $B * ($varH + $varZ) * $gammaIItb  + $D * $varCII - $varGammaII * $h0), 2);

            if ($sumb > $R) {
                $kl = "Điều kiện kiểm tra không thỏa mãn: ";
                $dau = ">";
            } else {
                $kl = "Điều kiện kiểm tra thỏa mãn: ";
                $dau = "≤";
            }
            $anpha = round($anpha, 4);
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\15.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);


            $templateProcessor->setValues(
                [
                    "varNII" => $varNII,
                    "varPhiII" => $varPhiII,
                    "varCII" => $varCII,
                    "varGammaII" => $varGammaII,
                    "varGammaIIPhay" => $varGammaIIPhay,
                    "varGammaII2Phay" => $varGammaII2Phay,
                    "varB" => $varB,
                    "varL" => $varL,
                    "varH" => $varH,
                    "varZ" => $varZ,
                    "varH1" => $varH1,
                    "varH2" => $varH2,
                    "varM1" => $varM1,
                    "varM2" => $varM2,
                    "varKtc" => $varKtc,
                    "poz" => $poz,
                    "pdz" => $pdz,
                    "R" => $R,
                    "p" => $p,
                    "po" => $po,
                    "pd" => $pd,
                    "sumb" => $sumb,
                    "anpha" => $anpha,
                    "h0" => $h0,
                    "a" => $a,
                    "Az" => $Az,
                    "bz" => $bz,
                    "gammaIItb" => $gammaIItb,
                    "m"  => $m,
                    "n" => $n,
                    "A" => $A,
                    "B" => $B,
                    "D" => $D,
                    "htd" => $htd,
                    "gammatc" => $gammatc,
                    "kl" => $kl,
                    "dau" => $dau

                ]
            );
            $timestamp = date('Ymd_His');
            $filename = 'kiem-tra-ung-suat-tai-mai-cua-lop-dat-mem_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;
            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('kiem-tra-ung-suat-tai-mai-cua-lop-dat-yeu', [
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }

    public function actionTinhNenTheoSucChiuTai()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/tinh-nen-theo-suc-chiu-tai']);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

            $Fv = $input['varFv'];
            $Fh = $input['varFh'];
            $Mb = $input['varMb'];
            $Ml = $input['varMl'];
            $phiI = deg2rad($input['varphiI']);
            $CI = $input['varCI'];
            $GammaIPhay = $input['varGammaIPhay'];
            $GammaI = $input['varGammaI'];
            $MNN = $input['varMNN'];
            $b = $input['varb'];
            $l = $input['varl'];
            $h = $input['varh'];
            $h1 = $input['varh1'];
            $ktc = $input['varktc'];

            $tanDelta = tan($Fh / $Fv);
            $delta = atan($Fh / $Fv);
            $sinphiI = sin($phiI);
            
            if ($tanDelta < $sinphiI) {
                $templateFile = "./file-tinh-toan/sample/25_TH1.docx";
                // Tinh toan

                $eb = $Mb / $Fv;
                $el = $Ml / $Fv;
                $bngang = $b - 2 * $eb;
                $lngang = $l - 2 * $el;

                $eta = $lngang / $bngang;
                
                if ($eta < 1) {
                    $eta = 1;
                }
                $nykq = 1 - 0.25 / $eta;
                $nqkq = 1 + 1.50 / $eta;
                $nckq = 1 + 0.30 / $eta;
                if ($eta > 5) {
                    $ny = 1;
                    $nc = 1;
                    $nq = 1; //móng băng
                } else {
                    $ny = $nykq;
                    $nq = $nqkq;
                    $nc = $nckq;
                }

                $lamda = 1 / 2 * (M_PI - $delta - asin(sin($delta) / sin($phiI)));

                for ($i = 0; $i < 3; $i++) {
                    switch ($i) {
                        case 0:
                            $alpha[0] = $phiI;
                            break;

                        case 1:
                            $alpha[1] = 2 * $lamda + $phiI;
                            break;

                        case 2:
                            $alpha[2] = 2 * $lamda - $phiI;
                            break;
                    }

                    $M[$i] = (1 + sin($alpha[$i])) / cos($alpha[$i]);
                }

                $E = exp($lamda * tan($phiI));

                $F = 1 - $M[2] * $tanDelta;

                $I = (cos($lamda) - $M[0] * sin($lamda)) * $E;

                $a = (1 - $I) / ($I * $M[1] - $M[0]);

                $R = (1 + $M[1] * $a) * (1 + sin($phiI) - 2 * pow(sin($lamda), 2));

                $cotphiI = 1 / tan($phiI);

                $Ny = 1 / (4 * $F) * (cos($alpha[1]) * (1 / sin($phiI) - $M[0] * pow($E, 2) * ($cotphiI + $a)) / $R + 2 * pow(cos($lamda), 2) / cos($phiI) - $M[0]);

                $Nq = $I / ($F * $R) * cos($phiI) * $M[1] * (1 + $M[0] * $a);

                $Nc = ($Nq - 1) / tan($phiI);

                $Phi = $bngang * $lngang * ($Ny * $ny * $bngang * $GammaI + $Nq * $nq * $h * $GammaIPhay + $Nc * $nc * $CI);

                $dk = $Phi / $ktc;
                if ($Fv <= $dk) {
                    $kl = "đảm bảo";
                } else {
                    $kl = "không đảm bảo";
                }
            } else {
                $templateFile = "./file-tinh-toan/sample/25_TH2.docx";

                $lamdaa = pow(tan(deg2rad(45) - $phiI / 2), 2);
                $lamdap = pow(tan(deg2rad(45) + $phiI / 2), 2);

                $hc = 2 * $CI * sqrt($lamdaa) / ($GammaIPhay * $lamdaa);

                $Eakq = 1 / 2 * ($GammaIPhay * $h1 * $lamdaa - 2 * $CI * $lamdaa) * ($h1 - $hc);
                $Ea = $Eakq < 0 ? 0 : $Eakq;

                $Ep = 1 / 2 * ($GammaIPhay * $h * $lamdap + ($CI * $h) / tan($phiI)) * ($lamdap - 1);

                $tongFgt = $Fh + $Ea;

                $ukq = 10 * ($h - $MNN);
                $u = $ukq < 0 ? 0 : $ukq;

                $A = $b * $l;

                $tongFct = ($Fv - $u * $A) * tan($phiI) + $A * $CI + $Ep;

                $dk = $tongFct / $tongFgt;
                
                $kl = $dk >= $ktc ? 'đảm bảo' : 'không đảm bảo';
                
            }


            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
            $templateProcessor->setValues(
                [
                    "Fv" => $Fv,
                    "Fh" => $Fh,
                    "Mb" => $Mb,
                    "Ml" => $Ml,
                    "phiI" => $phiI,
                    "phi1" => $input['varphiI'],
                    "CI" => $CI,
                    "GammaIPhay" => $GammaIPhay,
                    "GammaI" => $GammaI,
                    "MNN" => $MNN,
                    "b" => $b,
                    "l" => $l,
                    "h" => $h,
                    "h1" => $h1,
                    "ktc" => $ktc,
                    "tanDelta" => round($tanDelta, 2),
                    "delta" => round($delta, 2),
                    "sinphiI" => round($sinphiI, 3),
                    "dk" => round($dk, 2),
                    "kl" => $kl,
                    'thuong' => 'chữ thường',
                    'Thuong' => 'chữ cái đầu viết hoa',
                ]
            );

            if ($tanDelta < $sinphiI) {
                if ($eta > 5) {
                    $templateProcessor->replaceBlock('mongthuong', '');
                } else {
                    $templateProcessor->replaceBlock('mongbang', '');
                }

                $templateProcessor->setValues(
                    [
                        "eb" => round($eb, 2),
                        "el" => round($el, 2),
                        "bngang" => round($bngang, 2),
                        "lngang" => round($lngang, 2),
                        "eta" => round($eta, 2),
                        "ny" => round($ny, 2),
                        "nc" => round($nc, 2),
                        "nq" => round($nq, 2),
                        "nykq" => round($nykq, 2),
                        "nqkq" => round($nqkq, 2),
                        "nckq" => round($nckq, 2),
                        "lamda" => round($lamda, 2),
                        "alpha[0]" => round($alpha[0], 2),
                        "alpha[1]" => round($alpha[1], 2),
                        "alpha[2]" => round($alpha[2], 2),
                        "M[0]" => round($M[0], 2),
                        "M[1]" => round($M[1], 2),
                        "M[2]" => round($M[2], 2),
                        "E" => round($E, 2),
                        "F" => round($F, 2),
                        "I" => round($I, 2),
                        "a" => round($a, 2),
                        "R" => round($R, 2),
                        "cotphiI" => round($cotphiI, 2),
                        "Ny" => round($Ny, 2),
                        "Nq" => round($Nq, 2),
                        "Nc" => round($Nc, 2),
                        "Phi" => round($Phi, 0),
                    ]
                );
            } else {
                $templateProcessor->setValues(
                    [
                        "lamdaa" => round($lamdaa, 3),
                        "lamdap" => round($lamdap, 3),
                        "hc" => round($hc, 2),
                        "Eakq" => round($Eakq, 2),
                        "Ea" => round($Ea, 2),
                        "Ep" => round($Ep, 2),
                        "tongFgt" => round($tongFgt, 2),
                        "u" => $u,
                        "ukq" => $ukq,
                        "A" => round($A, 2),
                        "tongFct" => round($tongFct, 2),
                    ]
                );
            }


            $timestamp = date('Ymd_His');
            $filename = 'tinh-nen-theo-suc-chiu-tai_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;

            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('tinh-nen-theo-suc-chiu-tai', [
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }


    public function actionTinhToanCopPha()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/tinh-toan-cop-pha']);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();

           

            // $timestamp = date('Ymd_His');
            // $filename = 'tinh-nen-theo-suc-chiu-tai_' . $timestamp . '.docx';
            // $fileStorage = './file-tinh-toan/output/' . $filename;
            // $templateProcessor->saveAs($fileStorage);

            // $filePath = '/' . $fileStorage;

            // echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('tinh-toan-cop-pha', [
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }
}
