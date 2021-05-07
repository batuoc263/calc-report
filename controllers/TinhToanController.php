<?php

namespace app\controllers;
use Yii;
class TinhToanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionXacDinhApLucDuoiDayMongHinhChuNhat()
    {
        // Sample 01 
        if ($input = Yii::$app->request->post()) {
            // Trọng lượng bản thân của móng và đất:
            $G = $input["varGamma"] * $input["varB"] * $input["varL"] * $input["varHd"];
            // Tải trọng thẳng đứng có tính đến trọng lượng bản thân của móng và đất:
            $N = $input['varN'] + $G;
            
            // Diện tích đáy móng:
            $A = $input['varB'] * $input['varL'];
            
            // Monmen kháng uốn:
            $W_y = ($input['varB'] * pow($input['varL'], 2)) / 6;
            $W_x = ($input['varL'] * pow($input['varB'], 2)) / 6;

            // Monmen uốn tại đáy móng:
            $M_x = $input['varMx'] + $input['varQy'] * $input['varHm'];
            $M_y = $input['varMy'] + $input['varQx'] * $input['varHm'];

            // Kiểm tra độ lệch tâm:
            $e_x = $M_y / $N; $half_l = $input['varL'] / 2;
            $kl_e_x = ($e_x < $half_l) ? 'Thỏa/Tăng chiều dài móng' : 'Không thỏa/Chiều dài bla bla';
            $e_y = $M_x / $N; $half_b = $input['varB'] / 2;
            $kl_e_y = ($e_y < $half_b) ? 'Thỏa/Tăng chiều rộng móng' : 'Không thỏa/Chiều rộng bla bla';

            // Ứng suất tại các góc của đáy móng:
            $sigma1 = ($N / $A) + ($M_y / $W_y) + ($M_x / $W_x);
            $sigma2 = ($N / $A) + ($M_y / $W_y) - ($M_x / $W_x);
            $sigma3 = ($N / $A) - ($M_y / $W_y) + ($M_x / $W_x);
            $sigma4 = ($N / $A) - ($M_y / $W_y) - ($M_x / $W_x);

            echo '[varN] => 260
                [varMx] => 260
                [varQy] => 5
                [varMy] => 97
                [varQx] => 90
                [varL] => 2.4
                [varB] => 1.8
                [varHd] => 2.0
                [varHm] => 1.6
                [varGamma] => 20 <br>';

            echo "G = $G <br>" ;
            echo "N = $N <br>" ;
            echo "A = $A <br>" ;
            echo "W_y = $W_y <br>" ;
            echo "W_x = $W_x <br>" ;
            echo "W_y = $M_x <br>" ;
            echo "W_x = $M_y <br>" ;
            echo "e_x = $e_x <br>" ;
            echo "e_y = $e_y <br>" ;
            
            echo "sigma1 = ($N / $A) + ($M_y / $W_y) + ($M_x / $W_x) = $sigma1 <br>" ;
            echo "sigma2 = $sigma2 <br>" ;
            echo "sigma3 = $sigma3 <br>" ;
            echo "sigma4 = $sigma4 <br>" ;
            die;
        }
        return $this->render('xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat');
    }

}
