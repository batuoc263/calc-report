<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Xác định áp lực dưới đáy móng hình chữ nhật';
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tinhtoan-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Phương pháp này có thể xác định áp lực tại đáy móng dưới tác động của tải trọng ngang và momen theo hai phương x,y.</p>
    <p><u>Quy ước: </u></p>
    <ul>
        <li>+ Chiều dương của lực ngang Qx(y), tương ứng với chiều dương của của trục x (y);</li>
        <li>+ Chiều dương của momen Mx(y) xoay quanh trục x (y), tương ứng với chiều dương của trục y (x);</li>
        <li>+ Nếu trường hợp tính toán có tải trọng đứng, ngang hoặc momen uốn ngược chiều với hình 1 thì số liệu nhập vào bảng tính sẽ là giá trị âm.</li>
    </ul>
    <h3>THÔNG SỐ ĐẦU VÀO</h3>
    <form action="/tinh-toan/xac-dinh-ap-luc-duoi-day-mong-hinh-chu-nhat" method="post">

    <?=yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken)?>
    
    <table>
        <tr>
            <td><strong>Tải trọng tác dụng lên móng</strong></td>
        </tr>
        <tr>
            <td>Tải trọng đứng </td>
            <td> N= </td>
            <td>
                <input type="number" step="0.01" name="varN" id="varN"> kN
            </td>
        </tr>
        <tr>
            <td>Momen uốn, xoay quanh trục x </td>
            <td> Mx= </td>
            <td>
                <input type="number" step="0.01" name="varMx" id="varMx"> kN.m
            </td>
        </tr>
        <tr>
            <td>Lực ngang dọc theo trục y </td>
            <td> Qy= </td>
            <td>
                <input type="number" step="0.01" name="varQy" id="varQy"> kN
            </td>
        </tr>
        <tr>
            <td>Momen uốn, xoay quanh trục y </td>
            <td> My= </td>
            <td>
                <input type="number" step="0.01" name="varMy" id="varMy"> kN.m
            </td>
        </tr>
        <tr>
            <td>Lực ngang dọc theo trục x </td>
            <td> Qx= </td>
            <td>
                <input type="number" step="0.01" name="varQx" id="varQx"> kN
            </td>
        </tr>
        <!-- ============ -->
        <tr>
            <td><strong>Đặc trưng móng</strong></td>
        </tr>
        <tr>
            <td>Chiều dài đáy móng </td>
            <td> N= </td>
            <td>
                <input type="number" step="0.01" name="varL" id="varL"> kN
            </td>
        </tr>
        <tr>
            <td>Chiều rộng đáy móng </td>
            <td> Mx= </td>
            <td>
                <input type="number" step="0.01" name="varB" id="varB"> kN.m
            </td>
        </tr>
        <tr>
            <td>Chiều sâu từ mặt đất đến đáy móng </td>
            <td> Qy= </td>
            <td>
                <input type="number" step="0.01" name="varHd" id="varHd"> kN
            </td>
        </tr>
        <tr>
            <td style="width: 420px">Khoảng cách từ điểm đặt lực đến đáy móng </td>
            <td style="width: 50px"> My= </td>
            <td>
                <input type="number" step="0.01" name="varHm" id="varHm"> kN.m
            </td>
        </tr>
        <tr>
            <td>Trọng lương trung bình giữa đất và móng </td>
            <td> &gamma; <sub>tb</sub> = </td>
            <td>
                <input type="number" step="0.01" name="varGamma" id="varGamma"> kN
            </td>
        </tr>
    </table>
    <div class="number-center" style="margin-top: 10px">
        <img src="/images/01/h1.png" alt="Hình 1. Quy ước hướng của tải trọng tác dụng và kích thước hình học móng" width="800px">
    </div>
    <p class="number-center"><i>Hình 1. Quy ước hướng của tải trọng tác dụng và kích thước hình học móng</i></p>

    
    <div class="checkbox">
        <label>
            <input type="checkbox" name="newTabResult" value="">
            Mở kết quả trên tab mới
        </label>
    </div>
    
    <button type="submit" class="btn btn-primary">Tính toán</button>
    
    </form>
</div>