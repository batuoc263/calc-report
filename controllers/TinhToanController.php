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
                // Tinh toan

                $eb = abs($Mb) / $Fv;
                $el = abs($Ml) / $Fv;
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
                    $templateFile = "./file-tinh-toan/sample/25_TH1_2.docx";
                } else {
                    $ny = $nykq;
                    $nq = $nqkq;
                    $nc = $nckq;
                    $templateFile = "./file-tinh-toan/sample/25_TH1_1.docx";
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
                    $dau = "≤";
                } else {
                    $kl = "không đảm bảo";
                    $dau = ">";
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

                if ($dk >= $ktc) {
                    $kl = 'Điều kiện trượt tại đáy móng đảm bảo, móng không bị trượt';
                    $dau = "≥";
                } else {
                    $kl =  'Điều kiện trượt tại đáy móng không đảm bảo, móng bị trượt';
                    $dau = '<';
                }
                
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
                    'dau' => $dau
                ]
            );

            if ($tanDelta < $sinphiI) {
                
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

    public function actionTest($th = 1)
    {
        echo date('H:i:s'), ' Creating new TemplateProcessor instance...', PHP_EOL;
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan/sample/Sample_23_TemplateBlock.docx');

        if ($th==1) {
            # code...
            $templateProcessor->deleteBlock('BLOCK1');
            $templateProcessor->cloneBlock('BLOCK2', 1, true, false, [['bien1' => 'Bien 1', 'bien2' => 'bien222222', 'bien3' => 'varrrrrrrrr33333']]);
        } else {
            $templateProcessor->deleteBlock('BLOCK2');
            $templateProcessor->cloneBlock('BLOCK1', 1, true, false, [['bien1' => 'Bien 1', 'bien2' => 'bien222222', 'bien3' => 'varrrrrrrrr33333']]);
        }

        $templateProcessor->saveAs("./file-tinh-toan/output/Sample_23_TemplateBlock_$th.docx");
        echo date('H:i:s'), ' Saving the result document...', PHP_EOL;
    }

    public function actionTinhToanCopPha()
    {
        $dmtt = DmTinhtoan::findOne(['duong_dan' => '/tinh-toan/tinh-toan-cop-pha']);
        $menu = DmNhomBai::find()->asArray()->all();
        foreach ($menu as $key => $value) {
            $menu[$key]['children'] = DmTinhtoan::find()->where(['nhom_id' => $value['id']])->asArray()->all();
        }

        $arr = [];
        $arrI = [
                "Box steel 20x40x1.0" => "2.44", 
                "Box steel 20x40x1.2" => "2.87", 
                "Box steel 20x40x1.4" => "3.29", 
                "Box steel 20x40x1.5" => "3.49", 
                "Box steel 20x40x1.8" => "4.08", 
                "Box steel 20x40x2.0" => "4.45", 
                "Box steel 20x40x2.5" => "5.31", 
                "Box steel 20x40x3.0" => "6.08", 
                "Box steel 25x50x1.0" => "4.84", 
                "Box steel 25x50x1.2" => "5.73", 
                "Box steel 25x50x1.4" => "6.59", 
                "Box steel 25x50x1.5" => "7.01", 
                "Box steel 25x50x1.8" => "8.23", 
                "Box steel 25x50x2.0" => "9.01", 
                "Box steel 25x50x2.5" => "10.85", 
                "Box steel 25x50x3.0" => "12.55", 
                "Box steel 30x60x1.0" => "8.47", 
                "Box steel 30x60x1.2" => "10.05", 
                "Box steel 30x60x1.4" => "11.58", 
                "Box steel 30x60x1.5" => "12.33", 
                "Box steel 30x60x1.8" => "14.53", 
                "Box steel 30x60x2.0" => "15.95", 
                "Box steel 30x60x2.5" => "19.34", 
                "Box steel 30x60x3.0" => "22.51", 
                "Box steel 40x40x1.0" => "3.96", 
                "Box steel 40x40x1.2" => "4.68", 
                "Box steel 40x40x1.4" => "5.37", 
                "Box steel 40x40x1.5" => "5.72", 
                "Box steel 40x40x1.8" => "6.70", 
                "Box steel 40x40x2.0" => "7.34", 
                "Box steel 40x40x2.5" => "8.83", 
                "Box steel 40x40x3.0" => "10.20", 
                "Box steel 40x80x1.0" => "20.39", 
                "Box steel 40x80x1.2" => "24.25", 
                "Box steel 40x80x1.4" => "28.04", 
                "Box steel 40x80x1.5" => "29.90", 
                "Box steel 40x80x1.8" => "35.40", 
                "Box steel 40x80x2.0" => "38.97", 
                "Box steel 40x80x2.5" => "47.62", 
                "Box steel 40x80x3.0" => "55.85", 
                "Box steel 45x90x1.0" => "29.18", 
                "Box steel 45x90x1.2" => "34.74", 
                "Box steel 45x90x1.4" => "40.20", 
                "Box steel 45x90x1.5" => "42.90", 
                "Box steel 45x90x1.8" => "50.86", 
                "Box steel 45x90x2.0" => "56.06", 
                "Box steel 45x90x2.5" => "68.67", 
                "Box steel 45x90x3.0" => "80.75", 
                "Box steel 50x50x1.0" => "7.85", 
                "Box steel 50x50x1.2" => "9.30", 
                "Box steel 50x50x1.4" => "10.72", 
                "Box steel 50x50x1.5" => "11.42", 
                "Box steel 50x50x1.8" => "13.46", 
                "Box steel 50x50x2.0" => "14.77", 
                "Box steel 50x50x2.5" => "17.91", 
                "Box steel 50x50x3.0" => "20.85", 
                "Box steel 50x100x1.0" => "40.19", 
                "Box steel 50x100x1.2" => "47.88", 
                "Box steel 50x100x1.4" => "55.46", 
                "Box steel 50x100x1.5" => "59.20", 
                "Box steel 50x100x1.8" => "70.27", 
                "Box steel 50x100x2.0" => "77.52", 
                "Box steel 50x100x2.5" => "95.15", 
                "Box steel 50x100x3.0" => "112.12", 
                "Box steel 60x60x1.0" => "13.70", 
                "Box steel 60x60x1.2" => "16.27", 
                "Box steel 60x60x1.4" => "18.79", 
                "Box steel 60x60x1.5" => "20.03", 
                "Box steel 60x60x1.8" => "23.68", 
                "Box steel 60x60x2.0" => "26.05", 
                "Box steel 60x60x2.5" => "31.74", 
                "Box steel 60x60x3.0" => "37.14", 
                "Box steel 60x120x1.0" => "69.87", 
                "Box steel 60x120x1.2" => "83.34", 
                "Box steel 60x120x1.4" => "96.64", 
                "Box steel 60x120x1.5" => "103.23", 
                "Box steel 60x120x1.8" => "122.76", 
                "Box steel 60x120x2.0" => "135.58", 
                "Box steel 60x120x2.5" => "166.93", 
                "Box steel 60x120x3.0" => "197.31", 
                "2 x Box steel 20x40x1.0" => "4.87", 
                "2 x Box steel 20x40x1.2" => "5.74", 
                "2 x Box steel 20x40x1.4" => "6.58", 
                "2 x Box steel 20x40x1.5" => "6.98", 
                "2 x Box steel 20x40x1.8" => "8.15", 
                "2 x Box steel 20x40x2.0" => "8.89", 
                "2 x Box steel 20x40x2.5" => "10.61", 
                "2 x Box steel 20x40x3.0" => "12.16", 
                "2 x Box steel 25x50x1.0" => "9.69", 
                "2 x Box steel 25x50x1.2" => "11.46", 
                "2 x Box steel 25x50x1.4" => "13.18", 
                "2 x Box steel 25x50x1.5" => "14.01", 
                "2 x Box steel 25x50x1.8" => "16.45", 
                "2 x Box steel 25x50x2.0" => "18.02", 
                "2 x Box steel 25x50x2.5" => "21.71", 
                "2 x Box steel 25x50x3.0" => "25.11", 
                "2 x Box steel 30x60x1.0" => "16.95", 
                "2 x Box steel 30x60x1.2" => "20.09", 
                "2 x Box steel 30x60x1.4" => "23.16", 
                "2 x Box steel 30x60x1.5" => "24.66", 
                "2 x Box steel 30x60x1.8" => "29.06", 
                "2 x Box steel 30x60x2.0" => "31.90", 
                "2 x Box steel 30x60x2.5" => "38.68", 
                "2 x Box steel 30x60x3.0" => "45.01", 
                "2 x Box steel 40x40x1.0" => "7.91", 
                "2 x Box steel 40x40x1.2" => "9.35", 
                "2 x Box steel 40x40x1.4" => "10.75", 
                "2 x Box steel 40x40x1.5" => "11.43", 
                "2 x Box steel 40x40x1.8" => "13.41", 
                "2 x Box steel 40x40x2.0" => "14.67", 
                "2 x Box steel 40x40x2.5" => "17.66", 
                "2 x Box steel 40x40x3.0" => "20.39", 
                "2 x Box steel 40x80x1.0" => "40.78", 
                "2 x Box steel 40x80x1.2" => "48.50", 
                "2 x Box steel 40x80x1.4" => "56.07", 
                "2 x Box steel 40x80x1.5" => "59.80", 
                "2 x Box steel 40x80x1.8" => "70.79", 
                "2 x Box steel 40x80x2.0" => "77.95", 
                "2 x Box steel 40x80x2.5" => "95.24", 
                "2 x Box steel 40x80x3.0" => "111.71", 
                "2 x Box steel 45x90x1.0" => "58.36", 
                "2 x Box steel 45x90x1.2" => "69.47", 
                "2 x Box steel 45x90x1.4" => "80.40", 
                "2 x Box steel 45x90x1.5" => "85.80", 
                "2 x Box steel 45x90x1.8" => "101.72", 
                "2 x Box steel 45x90x2.0" => "112.11", 
                "2 x Box steel 45x90x2.5" => "137.33", 
                "2 x Box steel 45x90x3.0" => "161.49", 
                "2 x Box steel 50x50x1.0" => "15.69", 
                "2 x Box steel 50x50x1.2" => "18.61", 
                "2 x Box steel 50x50x1.4" => "21.45", 
                "2 x Box steel 50x50x1.5" => "22.84", 
                "2 x Box steel 50x50x1.8" => "26.91", 
                "2 x Box steel 50x50x2.0" => "29.54", 
                "2 x Box steel 50x50x2.5" => "35.82", 
                "2 x Box steel 50x50x3.0" => "41.70", 
                "2 x Box steel 50x100x1.0" => "80.38", 
                "2 x Box steel 50x100x1.2" => "95.76", 
                "2 x Box steel 50x100x1.4" => "110.91", 
                "2 x Box steel 50x100x1.5" => "118.41", 
                "2 x Box steel 50x100x1.8" => "140.55", 
                "2 x Box steel 50x100x2.0" => "155.04", 
                "2 x Box steel 50x100x2.5" => "190.30", 
                "2 x Box steel 50x100x3.0" => "224.24", 
                "2 x Box steel 60x60x1.0" => "27.39", 
                "2 x Box steel 60x60x1.2" => "32.54", 
                "2 x Box steel 60x60x1.4" => "37.58", 
                "2 x Box steel 60x60x1.5" => "40.07", 
                "2 x Box steel 60x60x1.8" => "47.36", 
                "2 x Box steel 60x60x2.0" => "52.09", 
                "2 x Box steel 60x60x2.5" => "63.49", 
                "2 x Box steel 60x60x3.0" => "74.28", 
                "2 x Box steel 60x120x1.0" => "139.74", 
                "2 x Box steel 60x120x1.2" => "166.68", 
                "2 x Box steel 60x120x1.4" => "193.29", 
                "2 x Box steel 60x120x1.5" => "206.47", 
                "2 x Box steel 60x120x1.8" => "245.53", 
                "2 x Box steel 60x120x2.0" => "271.16", 
                "2 x Box steel 60x120x2.5" => "333.86", 
                "2 x Box steel 60x120x3.0" => "394.61", 
                "Tubular steel Φ42x2.0" => "10.08", 
                "Tubular steel Φ49x1.2" => "8.69", 
                "Tubular steel Φ49x1.0" => "10.30", 
                "Tubular steel Φ49x1.4" => "11.87", 
                "Tubular steel Φ49x1.5" => "12.64", 
                "Tubular steel Φ49x1.8" => "14.89", 
                "Tubular steel Φ49x2.0" => "16.34", 
                "Tubular steel Φ49x2.5" => "19.80", 
                "Tubular steel Φ49x3.0" => "23.03", 
                "Tubular steel Φ60x1.0" => "16.14", 
                "Tubular steel Φ60x1.2" => "19.17", 
                "Tubular steel Φ60x1.4" => "22.14", 
                "Tubular steel Φ60x1.5" => "23.60", 
                "Tubular steel Φ60x1.8" => "27.90", 
                "Tubular steel Φ60x2.0" => "30.68", 
                "Tubular steel Φ60x2.5" => "37.40", 
                "Tubular steel Φ60x3.0" => "43.76", 
                "Tubular steel Φ76x1.0" => "33.14", 
                "Tubular steel Φ76x1.2" => "39.45", 
                "Tubular steel Φ76x1.4" => "45.67", 
                "Tubular steel Φ76x1.5" => "48.73", 
                "Tubular steel Φ76x1.8" => "57.79", 
                "Tubular steel Φ76x2.0" => "63.70", 
                "Tubular steel Φ76x2.5" => "78.05", 
                "Tubular steel Φ76x3.0" => "91.81", 
                " I-100x100x6x8" => "383.00", 
                " I-125x125x6.5x9" => "847.00", 
                " I-150x75x5x7" => "666.00", 
                " I-200x100x5.5x8" => "1840.00", 
                " I-248x124x5x8" => "3540.00", 
                " I-250x125x6x9" => "4050.00", 
                " I-298x149x5.5x8" => "6320.00", 
                " I-300x150x6.5x9" => "7210.00", 
                " I-300x200x8x12" => "11300.00", 
                " I-400x200x8x13" => "23700.00", 
                " I-400x300x9x14" => "33700.00", 
                " I-400x300x10x16" => "38700.00", 
                " I-450x200x8x12" => "28700.00", 
                " I-450x200x9x14" => "33500.00", 
                " I-450x300x10x15" => "46800.00", 
                " I-450x300x11x18" => "56100.00", 
                " H-200x200x8x12" => "4720.00", 
                " H-250x250x9x14" => "10800.00", 
                " H-300x300x10x15" => "20400.00", 
                " H-350x350x12x19" => "40300.00", 
                " H-400x400x13x21" => "66600.00", 
                " C 32x50" => "22.80", 
                " C 32x65" => "48.80", 
                " C 40x80" => "89.80", 
                " C 46x100" => "175.00", 
                " C 52x120" => "350.00", 
                " C 58x140" => "493.00", 
                " C 62x140" => "547.00", 
                " C 64x160" => "750.00", 
                " C 68x160" => "827.00", 
                " C 70x180" => "1090.00", 
                " C 74x180" => "1200.00", 
                " C 76x200" => "1530.00", 
                " C 80x200" => "1680.00", 
                " C 82x220" => "2120.00", 
                " C 87x220" => "2340.00", 
                " C 90x240" => "2910.00", 
                " C 95x240" => "3200.00", 
                " C 95x270" => "4180.00", 
                " C 100x300" => "5830.00", 
                " C 105x330" => "8010.00", 
                " C 110x360" => "10850.00" ];

        $arrW =    [
                "Box steel 20x40x1.0" => "1.22", 
                "Box steel 20x40x1.2" => "1.44", 
                "Box steel 20x40x1.4" => "1.64", 
                "Box steel 20x40x1.5" => "1.75", 
                "Box steel 20x40x1.8" => "2.04", 
                "Box steel 20x40x2.0" => "2.22", 
                "Box steel 20x40x2.5" => "2.65", 
                "Box steel 20x40x3.0" => "3.04", 
                "Box steel 25x50x1.0" => "1.94", 
                "Box steel 25x50x1.2" => "2.29", 
                "Box steel 25x50x1.4" => "2.64", 
                "Box steel 25x50x1.5" => "2.80", 
                "Box steel 25x50x1.8" => "3.29", 
                "Box steel 25x50x2.0" => "3.60", 
                "Box steel 25x50x2.5" => "4.34", 
                "Box steel 25x50x3.0" => "5.02", 
                "Box steel 30x60x1.0" => "2.82", 
                "Box steel 30x60x1.2" => "3.35", 
                "Box steel 30x60x1.4" => "3.86", 
                "Box steel 30x60x1.5" => "4.11", 
                "Box steel 30x60x1.8" => "4.84", 
                "Box steel 30x60x2.0" => "5.32", 
                "Box steel 30x60x2.5" => "6.45", 
                "Box steel 30x60x3.0" => "7.50", 
                "Box steel 40x40x1.0" => "1.98", 
                "Box steel 40x40x1.2" => "2.34", 
                "Box steel 40x40x1.4" => "2.69", 
                "Box steel 40x40x1.5" => "2.86", 
                "Box steel 40x40x1.8" => "3.35", 
                "Box steel 40x40x2.0" => "3.67", 
                "Box steel 40x40x2.5" => "4.41", 
                "Box steel 40x40x3.0" => "5.10", 
                "Box steel 40x80x1.0" => "5.10", 
                "Box steel 40x80x1.2" => "6.06", 
                "Box steel 40x80x1.4" => "7.01", 
                "Box steel 40x80x1.5" => "7.48", 
                "Box steel 40x80x1.8" => "8.85", 
                "Box steel 40x80x2.0" => "9.74", 
                "Box steel 40x80x2.5" => "11.90", 
                "Box steel 40x80x3.0" => "13.96", 
                "Box steel 45x90x1.0" => "6.48", 
                "Box steel 45x90x1.2" => "7.72", 
                "Box steel 45x90x1.4" => "8.93", 
                "Box steel 45x90x1.5" => "9.53", 
                "Box steel 45x90x1.8" => "11.30", 
                "Box steel 45x90x2.0" => "12.46", 
                "Box steel 45x90x2.5" => "15.26", 
                "Box steel 45x90x3.0" => "17.94", 
                "Box steel 50x50x1.0" => "3.14", 
                "Box steel 50x50x1.2" => "3.72", 
                "Box steel 50x50x1.4" => "4.29", 
                "Box steel 50x50x1.5" => "4.57", 
                "Box steel 50x50x1.8" => "5.38", 
                "Box steel 50x50x2.0" => "5.91", 
                "Box steel 50x50x2.5" => "7.16", 
                "Box steel 50x50x3.0" => "8.34", 
                "Box steel 50x100x1.0" => "8.04", 
                "Box steel 50x100x1.2" => "9.58", 
                "Box steel 50x100x1.4" => "11.09", 
                "Box steel 50x100x1.5" => "11.84", 
                "Box steel 50x100x1.8" => "14.05", 
                "Box steel 50x100x2.0" => "15.50", 
                "Box steel 50x100x2.5" => "19.03", 
                "Box steel 50x100x3.0" => "22.42", 
                "Box steel 60x60x1.0" => "4.57", 
                "Box steel 60x60x1.2" => "5.42", 
                "Box steel 60x60x1.4" => "6.26", 
                "Box steel 60x60x1.5" => "6.68", 
                "Box steel 60x60x1.8" => "7.89", 
                "Box steel 60x60x2.0" => "8.68", 
                "Box steel 60x60x2.5" => "10.58", 
                "Box steel 60x60x3.0" => "12.38", 
                "Box steel 60x120x1.0" => "11.64", 
                "Box steel 60x120x1.2" => "13.89", 
                "Box steel 60x120x1.4" => "16.11", 
                "Box steel 60x120x1.5" => "17.21", 
                "Box steel 60x120x1.8" => "20.46", 
                "Box steel 60x120x2.0" => "22.60", 
                "Box steel 60x120x2.5" => "27.82", 
                "Box steel 60x120x3.0" => "32.88", 
                "2 x Box steel 20x40x1.0" => "2.44", 
                "2 x Box steel 20x40x1.2" => "2.87", 
                "2 x Box steel 20x40x1.4" => "3.29", 
                "2 x Box steel 20x40x1.5" => "3.49", 
                "2 x Box steel 20x40x1.8" => "4.08", 
                "2 x Box steel 20x40x2.0" => "4.45", 
                "2 x Box steel 20x40x2.5" => "5.31", 
                "2 x Box steel 20x40x3.0" => "6.08", 
                "2 x Box steel 25x50x1.0" => "3.88", 
                "2 x Box steel 25x50x1.2" => "4.58", 
                "2 x Box steel 25x50x1.4" => "5.27", 
                "2 x Box steel 25x50x1.5" => "5.61", 
                "2 x Box steel 25x50x1.8" => "6.58", 
                "2 x Box steel 25x50x2.0" => "7.21", 
                "2 x Box steel 25x50x2.5" => "8.68", 
                "2 x Box steel 25x50x3.0" => "10.04", 
                "2 x Box steel 30x60x1.0" => "5.65", 
                "2 x Box steel 30x60x1.2" => "6.70", 
                "2 x Box steel 30x60x1.4" => "7.72", 
                "2 x Box steel 30x60x1.5" => "8.22", 
                "2 x Box steel 30x60x1.8" => "9.69", 
                "2 x Box steel 30x60x2.0" => "10.63", 
                "2 x Box steel 30x60x2.5" => "12.89", 
                "2 x Box steel 30x60x3.0" => "15.00", 
                "2 x Box steel 40x40x1.0" => "3.96", 
                "2 x Box steel 40x40x1.2" => "4.68", 
                "2 x Box steel 40x40x1.4" => "5.37", 
                "2 x Box steel 40x40x1.5" => "5.72", 
                "2 x Box steel 40x40x1.8" => "6.70", 
                "2 x Box steel 40x40x2.0" => "7.34", 
                "2 x Box steel 40x40x2.5" => "8.83", 
                "2 x Box steel 40x40x3.0" => "10.20", 
                "2 x Box steel 40x80x1.0" => "10.20", 
                "2 x Box steel 40x80x1.2" => "12.12", 
                "2 x Box steel 40x80x1.4" => "14.02", 
                "2 x Box steel 40x80x1.5" => "14.95", 
                "2 x Box steel 40x80x1.8" => "17.70", 
                "2 x Box steel 40x80x2.0" => "19.49", 
                "2 x Box steel 40x80x2.5" => "23.81", 
                "2 x Box steel 40x80x3.0" => "27.93", 
                "2 x Box steel 45x90x1.0" => "12.97", 
                "2 x Box steel 45x90x1.2" => "15.44", 
                "2 x Box steel 45x90x1.4" => "17.87", 
                "2 x Box steel 45x90x1.5" => "19.07", 
                "2 x Box steel 45x90x1.8" => "22.60", 
                "2 x Box steel 45x90x2.0" => "24.91", 
                "2 x Box steel 45x90x2.5" => "30.52", 
                "2 x Box steel 45x90x3.0" => "35.89", 
                "2 x Box steel 50x50x1.0" => "6.28", 
                "2 x Box steel 50x50x1.2" => "7.44", 
                "2 x Box steel 50x50x1.4" => "8.58", 
                "2 x Box steel 50x50x1.5" => "9.14", 
                "2 x Box steel 50x50x1.8" => "10.77", 
                "2 x Box steel 50x50x2.0" => "11.82", 
                "2 x Box steel 50x50x2.5" => "14.33", 
                "2 x Box steel 50x50x3.0" => "16.68", 
                "2 x Box steel 50x100x1.0" => "16.08", 
                "2 x Box steel 50x100x1.2" => "19.15", 
                "2 x Box steel 50x100x1.4" => "22.18", 
                "2 x Box steel 50x100x1.5" => "23.68", 
                "2 x Box steel 50x100x1.8" => "28.11", 
                "2 x Box steel 50x100x2.0" => "31.01", 
                "2 x Box steel 50x100x2.5" => "38.06", 
                "2 x Box steel 50x100x3.0" => "44.85", 
                "2 x Box steel 60x60x1.0" => "9.13", 
                "2 x Box steel 60x60x1.2" => "10.85", 
                "2 x Box steel 60x60x1.4" => "12.53", 
                "2 x Box steel 60x60x1.5" => "13.36", 
                "2 x Box steel 60x60x1.8" => "15.79", 
                "2 x Box steel 60x60x2.0" => "17.36", 
                "2 x Box steel 60x60x2.5" => "21.16", 
                "2 x Box steel 60x60x3.0" => "24.76", 
                "2 x Box steel 60x120x1.0" => "23.29", 
                "2 x Box steel 60x120x1.2" => "27.78", 
                "2 x Box steel 60x120x1.4" => "32.21", 
                "2 x Box steel 60x120x1.5" => "34.41", 
                "2 x Box steel 60x120x1.8" => "40.92", 
                "2 x Box steel 60x120x2.0" => "45.19", 
                "2 x Box steel 60x120x2.5" => "55.64", 
                "2 x Box steel 60x120x3.0" => "65.77", 
                "Tubular steel Φ42x2.0" => "1.89", 
                "Tubular steel Φ49x1.2" => "1.36", 
                "Tubular steel Φ49x1.0" => "1.62", 
                "Tubular steel Φ49x1.4" => "1.87", 
                "Tubular steel Φ49x1.5" => "1.99", 
                "Tubular steel Φ49x1.8" => "2.36", 
                "Tubular steel Φ49x2.0" => "2.60", 
                "Tubular steel Φ49x2.5" => "3.19", 
                "Tubular steel Φ49x3.0" => "3.74", 
                "Tubular steel Φ60x1.0" => "2.05", 
                "Tubular steel Φ60x1.2" => "2.44", 
                "Tubular steel Φ60x1.4" => "2.83", 
                "Tubular steel Φ60x1.5" => "3.02", 
                "Tubular steel Φ60x1.8" => "3.59", 
                "Tubular steel Φ60x2.0" => "3.96", 
                "Tubular steel Φ60x2.5" => "4.87", 
                "Tubular steel Φ60x3.0" => "5.75", 
                "Tubular steel Φ76x1.0" => "3.31", 
                "Tubular steel Φ76x1.2" => "3.96", 
                "Tubular steel Φ76x1.4" => "4.59", 
                "Tubular steel Φ76x1.5" => "4.90", 
                "Tubular steel Φ76x1.8" => "5.84", 
                "Tubular steel Φ76x2.0" => "6.45", 
                "Tubular steel Φ76x2.5" => "7.96", 
                "Tubular steel Φ76x3.0" => "9.42", 
                " I-100x100x6x8" => "87.60", 
                " I-125x125x6.5x9" => "154.00", 
                " I-150x75x5x7" => "102.00", 
                " I-200x100x5.5x8" => "209.00", 
                " I-248x124x5x8" => "319.00", 
                " I-250x125x6x9" => "366.00", 
                " I-298x149x5.5x8" => "475.00", 
                " I-300x150x6.5x9" => "542.00", 
                " I-300x200x8x12" => "859.00", 
                " I-400x200x8x13" => "1330.00", 
                " I-400x300x9x14" => "1920.00", 
                " I-400x300x10x16" => "2190.00", 
                " I-450x200x8x12" => "1450.00", 
                " I-450x200x9x14" => "1680.00", 
                " I-450x300x10x15" => "2380.00", 
                " I-450x300x11x18" => "2820.00", 
                " H-200x200x8x12" => "525.00", 
                " H-250x250x9x14" => "960.00", 
                " H-300x300x10x15" => "1500.00", 
                " H-350x350x12x19" => "2550.00", 
                " H-400x400x13x21" => "3670.00", 
                " C 32x50" => "9.17", 
                " C 32x65" => "15.00", 
                " C 40x80" => "22.50", 
                " C 46x100" => "34.90", 
                " C 52x120" => "50.80", 
                " C 58x140" => "70.40", 
                " C 62x140" => "78.20", 
                " C 64x160" => "93.80", 
                " C 68x160" => "103.00", 
                " C 70x180" => "121.00", 
                " C 74x180" => "133.00", 
                " C 76x200" => "153.00", 
                " C 80x200" => "168.00", 
                " C 82x220" => "193.00", 
                " C 87x220" => "212.00", 
                " C 90x240" => "243.00", 
                " C 95x240" => "266.00", 
                " C 95x270" => "310.00", 
                " C 100x300" => "389.00", 
                " C 105x330" => "486.00", 
                " C 110x360" => "603.00" ];
        ;
        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            $dmtt->luot_giai++;
            $dmtt->save();
            $checkP = 0;
            if ($input['loai'] == 'san') {
                // van ep
                $templateFile = './file-tinh-toan/sample/23_TH1.docx';
                $qtt1 = $input['SvarSumQtt'] * $input['SvarB'];
                $qtc1 = $input['SvarSumQtc'] * $input['SvarB'];

                $M1 = round (($qtt1 * pow($input['SvarL1'], 2) / 10 ), 3 );

                $sigma1 = round($M1 / ($input['SvarW1'] /1000000) , 3 );
                $teta1 = round( ($input['SvarSigma1'] - $sigma1 ) *100 / $sigma1, 2 );
                if ($sigma1 <= $input['SvarSigma1']) {
                    $dau12 = "≤";
                } else {
                    $dau12 = ">";
                }

                $f1 = round( (5/384) * ($qtc1 * pow($input['SvarL1'], 4)) * 1000 / ($input['SvarE1']  * $input['SvarI1'] / 100000000) , 1);
                
                $ghf1 = round((3/1000) * $input['SvarL1'] *1000, 1);
                $tetaF1 = round((($ghf1 - $f1 ) / $f1 ) * 100, 1);
                if ($f1 <= $ghf1) {
                    $dau1 = "≤";
                    $dk1 = "thỏa mãn";
                } else {
                    $dau1 = ">";
                    $dk1 = "không thỏa mãn";
                }
                
            
            

                // da phu
                
                $qtt2 = $input['SvarSumQtt'] * $input['SvarL1'];
                $qtc2 = $input['SvarSumQtc'] * $input['SvarL1'];

                $M2 = round (($qtt2 * pow($input['SvarL2'], 2) / 10 ), 3 );

                $sigma2 = round($M2 / ($input['SvarW2'] /1000000) , 3 );
                $teta2 = round( ($input['SvarSigma2'] - $sigma2 ) *100 / $sigma2, 2 );
                if ($sigma2 <= $input['SvarSigma2']) {
                    $dau27 = "≤";
                } else {
                    $dau27 = ">";
                }

                $f2 = round( (5/384) * ($qtc2 * pow($input['SvarL2'], 4)) * 1000 / ($input['SvarE2'] * $input['SvarI2'] / 100000000) , 1);
                $ghf2 = round((3/1000) * $input['SvarL2'] *1000, 1);
                $tetaF2 = round((($ghf2 - $f2 ) / $f2 ) * 100, 1);
                if ($f2 <= $ghf2) {
                    $dau2 = "≤";
                    $dk2 = "thỏa mãn";
                } else {
                    $dau2 = ">";
                    $dk2 = "không thỏa mãn";
                }

                // da chinh

                $qtt3 = $input['SvarSumQtt'] * $input['SvarL2'];
                $qtc3 = $input['SvarSumQtc'] * $input['SvarL2'];

                $M3 = round (($qtt3 * pow($input['SvarL3'], 2) / 10 ), 3 );

                $sigma3 = round($M3 / ($input['SvarW3'] /1000000) , 3 );
                $teta3 = round( ($input['SvarSigma3'] - $sigma3 ) *100 / $sigma3, 2 );
                if ($sigma3 <= $input['SvarSigma3']) {
                    $dau312 = "≤";
                } else {
                    $dau312 = ">";
                }

                $f3 = round( (5/384) * ($qtc3 * pow($input['SvarL3'], 4)) * 1000 / ($input['SvarE3']  * $input['SvarI3'] / 100000000 ) , 1);
                $ghf3 = round((3/1000) * $input['SvarL3'] *1000, 1);
                $tetaF3 = round((($ghf3 - $f3 ) / $f3 ) * 100, 1);
                if ($f3 <= $ghf3) {
                    $dau3 = "≤";
                    $dk3 = "thỏa mãn";
                } else {
                    $dau3 = ">";
                    $dk3 = "không thỏa mãn";
                }

                // cây chống

                $P = round ($input['SvarSumQtt'] * $input['SvarS'], 2 );
                $tetaP = round(($input['SvarP'] - $P ) * 100 / $P, 0);
                if ($P <= $input['SvarP']) {
                    $dau4 = "≤";
                    $dk4 = "thỏa mãn";
                } else {
                    $dau4 = ">";
                    $dk4 = "không thỏa mãn";
                }

            } elseif ($input['loai'] == 'dam') {
                // van ep
                $templateFile = './file-tinh-toan/sample/23_TH2.docx';
                
                $qtt1 = $input['DvarSumQtt'] * $input['DvarB'];
                $qtc1 = $input['DvarSumQtc'] * $input['DvarB'];

                $M1 = round (($qtt1 * pow($input['DvarL1'], 2) / 10 ), 3 );

                $sigma1 = round($M1 / ($input['DvarW1'] /1000000) , 3 );
                $teta1 = round( ($input['DvarSigma1'] - $sigma1 ) *100 / $sigma1, 2 );

                if ($sigma1 <= $input['SvarSigma1']) {
                    $dau12 = "≤";
                } else {
                    $dau12 = ">";
                }
                $f1 = round( (5/384) * ($qtc1 * pow($input['DvarL1'], 4)) * 1000 / ($input['DvarE1']  * $input['DvarI1'] / 100000000) , 2);
                
                $ghf1 = round((3/1000) * $input['DvarL1'] *1000, 2);
                $tetaF1 = round((($ghf1 - $f1 ) / $f1 ) * 100, 0);
                if ($f1 <= $ghf1) {
                    $dau1 = "≤";
                    $dk1 = "thỏa mãn";
                } else {
                    $dau1 = ">";
                    $dk1 = "không thỏa mãn";
                }

                // da phu

                $qtt2 = $input['DvarSumQtt'] * $input['DvarL1'];
                $qtc2 = $input['DvarSumQtc'] * $input['DvarL1'];

                $M2 = round (($qtt2 * pow($input['DvarL2'], 2) / 10 ), 3 );

                $sigma2 = round($M2 / ($input['DvarW2'] /1000000) , 3 );
                $teta2 = round( ($input['DvarSigma2'] - $sigma2 ) *100 / $sigma2, 2 );
                if ($sigma2 <= $input['SvarSigma2']) {
                    $dau27 = "≤";
                } else {
                    $dau27 = ">";
                }

                $f2 = round( (5/384) * ($qtc2 * pow($input['DvarL2'], 4)) * 1000 / ($input['DvarE2'] * $input['DvarI2'] / 100000000) , 1);
                $ghf2 = round((3/1000) * $input['DvarL2'] *1000, 1);
                $tetaF2 = round((($ghf2 - $f2 ) / $f2 ) * 100, 1);
                if ($f2 <= $ghf2) {
                    $dau2 = "≤";
                    $dk2 = "thỏa mãn";
                } else {
                    $dau2 = ">";
                    $dk2 = "không thỏa mãn";
                }
                // da chinh

                $qtt3 = $input['DvarSumQtt'] * $input['DvarL2'] * ($input['DvarBd'] / $input['DvarL3']);
                $qtc3 = $input['DvarSumQtc'] * $input['DvarL2'] * ($input['DvarBd'] / $input['DvarL3']);

                $M3 = round (($qtt3 * pow($input['DvarL3'], 2) / 10 ), 3 );

                $sigma3 = round($M3 / ($input['DvarW3'] /1000000) , 3 );
                $teta3 = round( ($input['DvarSigma3'] - $sigma3 ) *100 / $sigma3, 2 );
                if ($sigma3 <= $input['SvarSigma3']) {
                    $dau312 = "≤";
                } else {
                    $dau312 = ">";
                }

                $f3 = round( (5/384) * ($qtc3 * pow($input['DvarL3'], 4)) * 1000 / ($input['DvarE3']  * $input['DvarI3'] / 100000000 ) , 1);
                $ghf3 = round((3/1000) * $input['DvarL3'] *1000, 1);
                $tetaF3 = round((($ghf3 - $f3 ) / $f3 ) * 100, 0);
                if ($f3 <= $ghf3) {
                    $dau3 = "≤";
                    $dk3 = "thỏa mãn";
                } else {
                    $dau3 = ">";
                    $dk3 = "không thỏa mãn";
                }
                 // cây chống

                 $P = round ($input['DvarSumQtt'] * $input['DvarS'], 1 );
                 $tetaP = round(($input['DvarP'] - $P ) * 100 / $P, 0);
                 if ($P <= $input['SvarP']) {
                    $dau4 = "≤";
                    $dk4 = "thỏa mãn";
                } else {
                    $dau4 = ">";
                    $dk4 = "không thỏa mãn";
                }
               
            } else {
                // van ep
                $templateFile = './file-tinh-toan/sample/23_TH3.docx';
                $qtt1 = $input['CvarSumQtt'] * $input['CvarB'];
                $qtc1 = $input['CvarSumQtc'] * $input['CvarB'];

                $M1 = round (($qtt1 * pow($input['CvarL1'], 2) / 10 ), 3 );

                $sigma1 = round($M1 / ($input['CvarW1'] /1000000) , 3 );
                $teta1 = round( ($input['CvarSigma1'] - $sigma1 ) *100 / $sigma1, 2 );

                if ($sigma1 <= $input['SvarSigma1']) {
                    $dau12 = "≤";
                } else {
                    $dau12 = ">";
                }

                $f1 = round( (5/384) * ($qtc1 * pow($input['CvarL1'], 4)) * 1000 / ($input['CvarE1']  * $input['CvarI1'] / 100000000) , 2);
                
                $ghf1 = round((3/1000) * $input['CvarL1'] *1000, 2);
                $tetaF1 = round((($ghf1 - $f1 ) / $f1 ) * 100, 0);
                if ($f1 <= $ghf1) {
                    $dau1 = "≤";
                    $dk1 = "thỏa mãn";
                } else {
                    $dau1 = ">";
                    $dk1 = "không thỏa mãn";
                }

                 // suon phu

                 $qtt2 = $input['CvarSumQtt'] * $input['CvarL1'];
                 $qtc2 = $input['CvarSumQtc'] * $input['CvarL1'];
 
                 $M2 = round (($qtt2 * pow($input['CvarL2'], 2) / 10 ), 3 );
 
                 $sigma2 = round($M2 / ($input['CvarW2'] /1000000) , 3 );
                 $teta2 = round( ($input['CvarSigma2'] - $sigma2 ) *100 / $sigma2, 2 );
                 if ($sigma2 <= $input['SvarSigma2']) {
                    $dau27 = "≤";
                } else {
                    $dau27 = ">";
                }
 
                 $f2 = round( (5/384) * ($qtc2 * pow($input['CvarL2'], 4)) * 1000 / ($input['CvarE2'] * $input['CvarI2'] / 100000000) , 1);
                 $ghf2 = round((3/1000) * $input['CvarL2'] *1000, 1);
                 $tetaF2 = round((($ghf2 - $f2 ) / $f2 ) * 100, 1);
                 if ($f2 <= $ghf2) {
                    $dau2 = "≤";
                    $dk2 = "thỏa mãn";
                } else {
                    $dau2 = ">";
                    $dk2 = "không thỏa mãn";
                }
                 // da chinh

                $qtt3 = $input['CvarSumQtt'] * $input['CvarL2'] ;
                $qtc3 = $input['CvarSumQtc'] * $input['CvarL2'] ;

                $M3 = round (($qtt3 * pow($input['CvarL3'], 2) / 10 ), 3 );

                $sigma3 = round($M3 / ($input['CvarW3'] /1000000) , 3 );
                $teta3 = round( ($input['CvarSigma3'] - $sigma3 ) *100 / $sigma3, 2 );
                if ($sigma3 <= $input['SvarSigma3']) {
                    $dau312 = "≤";
                } else {
                    $dau312 = ">";
                }

                $f3 = round( (5/384) * ($qtc3 * pow($input['CvarL3'], 4)) * 1000 / ($input['CvarE3']  * $input['CvarI3'] / 100000000 ) , 1);
                $ghf3 = round((3/1000) * $input['CvarL3'] *1000, 1);
                $tetaF3 = round((($ghf3 - $f3 ) / $f3 ) * 100, 0);
                if ($f3 <= $ghf3) {
                    $dau3 = "≤";
                    $dk3 = "thỏa mãn";
                } else {
                    $dau3 = ">";
                    $dk3 = "không thỏa mãn";
                }
                 // cây chống

                 $P = round ( $qtt3 * $input['CvarL3'], 1 );
                 $checkP = round( ((PI() * pow($input['CvarD'] / 1000, 2)) / 4 ) * $input['CvarSigma4'], 2 );
                 $tetaP = round(($checkP - $P ) * 100 / $P, 0);
                 if ($P <= $checkP) {
                    $dau4 = "≤";
                    $dk4 = "thỏa mãn";
                } else {
                    $dau4 = ">";
                    $dk4 = "không thỏa mãn";
                }
            }

            
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./file-tinh-toan\sample\15.docx');
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);


            $templateProcessor->setValues(
                [
                'qtt1' => $qtt1,
                'qtc1' => $qtc1,
                'M1' => $M1,
                'sigma1' => $sigma1,
                'teta1' => $teta1,
                'f1' => $f1,
                'ghf1' => $ghf1,
                'tetaF1' =>  $tetaF1,
                'dau1' => $dau1,
                'dk1'  => $dk1 ,

                'qtt2' => $qtt2,
                'qtc2' => $qtc2,
                'M2' => $M2,
                'sigma2' => $sigma2,
                'teta2' => $teta2,
                'f2' => $f2,
                'ghf2' => $ghf2,
                'tetaF2' =>  $tetaF2,
                'dau2' => $dau2,
                'dk2'  => $dk2 ,

                'qtt3' => $qtt3,
                'qtc3' => $qtc3,
                'M3' => $M3,
                'sigma3' => $sigma3,
                'teta3' => $teta3,
                'f3' => $f3,
                'ghf3' => $ghf3,
                'tetaF3' =>  $tetaF3,
                'dau3' => $dau3,
                'dk3'  => $dk3,

                'dau12' => $dau12,
                'dau27' => $dau27,
                'dau312' => $dau312,

                'P' =>  $P,
                'tetaP' => $tetaP,
                'dau4' => $dau4,
                'dk4'  => $dk4 ,
                'checkP' =>  $checkP,

                'SvarHs' => $input['SvarHs'],
                'SvarGammab' => $input['SvarGammab'],
                'SvarH1' => $input['SvarH1'],
                'SvarGamma1' => $input['SvarGamma1'],
                'SvarB' => $input['SvarB'],
                'SvarI1' => $input['SvarI1'],
                'SvarW1' => $input['SvarW1'],
                'SvarSigma1' => $input['SvarSigma1'],
                'SvarE1' => $input['SvarE1'],
                'SvarGamma2' => $input['SvarGamma2'],
                'SvarGamma3' => $input['SvarGamma3'],
                'SvarI2' => $input['SvarI2'],
                'SvarI3' => $input['SvarI3'],
                'SvarW2' => $input['SvarW2'],
                'SvarW3' => $input['SvarW3'],
                'SvarSigma2' => $input['SvarSigma2'],
                'SvarSigma3' => $input['SvarSigma3'],
                'SvarE2' => $input['SvarE2'],
                'SvarE3' => $input['SvarE3'],
                'SvarS' => $input['SvarS'],
                'SvarP' => $input['SvarP'],
                'SvarL1' => $input['SvarL1'],
                'SvarL2' => $input['SvarL2'],
                'SvarL3' => $input['SvarL3'],
                'SvarN1' => $input['SvarN1'],
                'SvarN2' => $input['SvarN2'],
                'SvarN3' => $input['SvarN3'],
                'SvarN4' => $input['SvarN4'],
                'SvarN5' => $input['SvarN5'],
                'SvarQtc1' => $input['SvarQtc1'],
                'SvarQtc2' => $input['SvarQtc2'],
                'SvarQtc3' => $input['SvarQtc3'],
                'SvarQtc4' => $input['SvarQtc4'],
                'SvarQtc5' => $input['SvarQtc5'],
                'SvarQtt1' => $input['SvarQtt1'],
                'SvarQtt2' => $input['SvarQtt2'],
                'SvarQtt3' => $input['SvarQtt3'],
                'SvarQtt4' => $input['SvarQtt4'],
                'SvarQtt5' => $input['SvarQtt5'],
                'SvarSumQtc' => $input['SvarSumQtc'],
                'SvarSumQtt' => $input['SvarSumQtt'],
                'Sloai1' => $input['Sloai1'],
                'Sloai2' => $input['Sloai2'],

                'DvarHd' => $input['DvarHd'],
                'DvarBd' => $input['DvarBd'],
                'DvarGammab' => $input['DvarGammab'],
                'DvarH1' => $input['DvarH1'],
                'DvarGamma1' => $input['DvarGamma1'],
                'DvarB' => $input['DvarB'],
                'DvarI1' => $input['DvarI1'],
                'DvarW1' => $input['DvarW1'],
                'DvarSigma1' => $input['DvarSigma1'],
                'DvarE1' => $input['DvarE1'],
                'DvarGamma2' => $input['DvarGamma2'],
                'DvarGamma3' => $input['DvarGamma3'],
                'DvarI2' => $input['DvarI2'],
                'DvarI3' => $input['DvarI3'],
                'DvarW2' => $input['DvarW2'],
                'DvarW3' => $input['DvarW3'],
                'DvarSigma2' => $input['DvarSigma2'],
                'DvarSigma3' => $input['DvarSigma3'],
                'DvarE2' => $input['DvarE2'],
                'DvarE3' => $input['DvarE3'],
                'DvarS' => $input['DvarS'],
                'DvarP' => $input['DvarP'],
                'DvarL1' => $input['DvarL1'],
                'DvarL2' => $input['DvarL2'],
                'DvarL3' => $input['DvarL3'],
                'DvarN1' => $input['DvarN1'],
                'DvarN2' => $input['DvarN2'],
                'DvarN3' => $input['DvarN3'],
                'DvarN4' => $input['DvarN4'],
                'DvarN5' => $input['DvarN5'],
                'DvarQtc1' => $input['DvarQtc1'],
                'DvarQtc2' => $input['DvarQtc2'],
                'DvarQtc3' => $input['DvarQtc3'],
                'DvarQtc4' => $input['DvarQtc4'],
                'DvarQtc5' => $input['DvarQtc5'],
                'DvarQtt1' => $input['DvarQtt1'],
                'DvarQtt2' => $input['DvarQtt2'],
                'DvarQtt3' => $input['DvarQtt3'],
                'DvarQtt4' => $input['DvarQtt4'],
                'DvarQtt5' => $input['DvarQtt5'],
                'DvarSumQtc' => $input['DvarSumQtc'],
                'DvarSumQtt' => $input['DvarSumQtt'],
                'Dloai1' => $input['Dloai1'],
                'Dloai2' => $input['Dloai2'],


                'CvarHc' => $input['CvarHc'],
                'CvarGammab' => $input['CvarGammab'],
                'CvarH1' => $input['CvarH1'],
                'CvarGamma1' => $input['CvarGamma1'],
                'CvarB' => $input['CvarB'],
                'CvarI1' => $input['CvarI1'],
                'CvarW1' => $input['CvarW1'],
                'CvarSigma1' => $input['CvarSigma1'],
                'CvarE1' => $input['CvarE1'],
                'CvarGamma2' => $input['CvarGamma2'],
                'CvarGamma3' => $input['CvarGamma3'],
                'CvarI2' => $input['CvarI2'],
                'CvarI3' => $input['CvarI3'],
                'CvarW2' => $input['CvarW2'],
                'CvarW3' => $input['CvarW3'],
                'CvarSigma2' => $input['CvarSigma2'],
                'CvarSigma3' => $input['CvarSigma3'],
                'CvarE2' => $input['CvarE2'],
                'CvarE3' => $input['CvarE3'],
                'CvarD' => $input['CvarD'],
                'CvarSigma4' => $input['CvarSigma4'],
                'CvarE22' => $input['CvarE22'],
                'CvarL1' => $input['CvarL1'],
                'CvarL2' => $input['CvarL2'],
                'CvarL3' => $input['CvarL3'],
                'CvarN1' => $input['CvarN1'],
                'CvarN2' => $input['CvarN2'],
                'CvarQtc1' => $input['CvarQtc1'],
                'CvarQtc2' => $input['CvarQtc2'],
                'CvarQtt1' => $input['CvarQtt1'],
                'CvarQtt2' => $input['CvarQtt2'],
                'CvarSumQtc' => $input['CvarSumQtc'],
                'CvarSumQtt' => $input['CvarSumQtt'],
                'Cloai1' => $input['Cloai1'],
                'Cloai2' => $input['Cloai2'],

                ]
            );
            $timestamp = date('Ymd_His');
            $filename = 'tinh_toan_cop_pha_' . $timestamp . '.docx';
            $fileStorage = './file-tinh-toan/output/' . $filename;
            $templateProcessor->saveAs($fileStorage);

            $filePath = '/' . $fileStorage;
            echo json_encode(['filePath' => $filePath, 'luot_tinh' => $dmtt->luot_giai]);
            return;
        }
        return $this->render('tinh-toan-cop-pha', [
            'arrI' => $arrI,
            'arrW' => $arrW,
            'dmtt' => $dmtt,
            'menu' => $menu,
        ]);
    }
}
