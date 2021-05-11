<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Xác định áp lực dưới đáy móng tròn';
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tinhtoan-content">
    <div class="text-center">
        <h1 class="text-uppercase" style="font-size: 25px;"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="col-md-9">
        <div id="result">

        </div>

        <p>Phương pháp này có thể xác định áp lực tại đáy móng tròn dưới tác động của tải trọng ngang và momen theo hai hướng x,y.</p>
        <p><u>Quy ước: </u></p>
        <ul>
            <li>Chiều dương của lực ngang Qx(y), tương ứng với chiều dương của của trục x (y);</li>
            <li>Chiều dương của momen Mx(y) xoay quanh trục x (y), tương ứng với chiều dương của trục y (x);</li>
            <li>Nếu trường hợp tính toán có tải trọng đứng, ngang hoặc momen uốn ngược chiều với hình 1 thì số liệu nhập vào bảng tính sẽ là giá trị âm.</li>
        </ul>
        <h3>THÔNG SỐ ĐẦU VÀO</h3>
        <table>
            <tr>
                <td><strong>Lực tác dụng lên móng</strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Lực đứng </td>
                <td style="width: 50px"> N = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" lang="en" value="260.0" step="0.01" name="varN" id="varN"> kN
                </td>
            </tr>
            <tr>
                <td>Momen uốn, xoay quanh trục x </td>
                <td> Mx = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="20.0" step="0.01" name="varMx" id="varMx"> kN.m
                </td>
            </tr>
            <tr>
                <td>Lực ngang dọc theo trục y </td>
                <td> Qy = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="5.0" step="0.01" name="varQy" id="varQy"> kN
                </td>
            </tr>
            <tr>
                <td>Momen uốn, xoay quanh trục y </td>
                <td> My = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="97.0" step="0.01" name="varMy" id="varMy"> kN.m
                </td>
            </tr>
            <tr>
                <td>Lực ngang dọc theo trục x </td>
                <td> Qx = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="90.0" step="0.01" name="varQx" id="varQx"> kN
                </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng móng</strong></td>
            </tr>
            <tr>
                <td>Đường kính đáy móng </td>
                <td> D = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="2.4" step="0.01" name="varD" id="varD"> kN
                </td>
            </tr>
            <tr>
                <td>Chiều sâu từ mặt đất đến đáy móng </td>
                <td> h<sub>d</sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="2.0" step="0.01" name="varHd" id="varHd"> kN
                </td>
            </tr>
            <tr>
                <td>Khoảng cách từ điểm đặt lực đến đáy móng </td>
                <td> h<sub>m</sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="1.6" step="0.01" name="varHm" id="varHm"> kN.m
                </td>
            </tr>
            <tr>
                <td>Trọng lương trung bình giữa đất và móng </td>
                <td> &gamma;<sub>tb</sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="20.0" step="0.01" name="varGamma" id="varGamma"> kN
                </td>
            </tr>
        </table>
        <div class="text-center" style="margin-top: 10px">
            <img src="/images/02/day-mong-tron.png" alt="Hình 1. Quy ước hướng của tải trọng tác dụng và kích thước hình học móng" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Quy ước hướng của tải trọng tác dụng và kích thước hình học móng</i></p>

        <!-- <div class="checkbox">
                <label>
                    <input type="checkbox" name="newTabResult" value="">
                    Mở kết quả trên tab mới
                </label>
            </div> -->
        <hr>
        <div class="row">
            <div class="col-md-6">
                <button onclick="tinhtoan()" class="btn btn-primary">Tính toán</button>
            </div>
            <div class="col-md-3">Lượt tính: <span id="luot_tinh"><?= $dmtt->luot_giai ?></span></div>
            <div class="col-md-3">

                <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="small">
                    <a data-label="Facebook" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="fb-xfbml-parse-ignore">
                        <img src="/images/fbshare.PNG" alt="Share Facebook">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => "",
            'columns' => [
                [
                    'attribute' => 'ten_bai_toan',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<a href="' . $model->duong_dan . '">' . $model->ten_bai_toan . '</a>';
                    }
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>

</div>

<script>
    function tinhtoan() {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        varN = $('#varN').val()
        varMx = $('#varMx').val()
        varQy = $('#varQy').val()
        varMy = $('#varMy').val()
        varQx = $('#varQx').val()
        varD = $('#varD').val()
        varHd = $('#varHd').val()
        varHm = $('#varHm').val()
        varGamma = $('#varGamma').val()
        data= {
                _token: CSRF_TOKEN,
                varN: varN,
                varMx: varMx,
                varQy: varQy,
                varMy: varMy,
                varQx: varQx,
                varD: varD,
                varHd: varHd,
                varHm: varHm,
                varGamma: varGamma
            };

        console.log(data);
        $.ajax({
            method: "POST",
            url: "/tinh-toan/xac-dinh-ap-luc-duoi-day-mong-tron",
            data: data
        }).done(function(msg) {
           
            rs = JSON.parse(msg);
            $('#result').html('<div class="alert alert-success" role="alert">Báo cáo của bạn đã sẵn sàng để tải xuống. <a href="' + rs.filePath + '">Tải xuống</a></div>')
            $('#luot_tinh').html(rs.luot_tinh)
        });
    }
</script>