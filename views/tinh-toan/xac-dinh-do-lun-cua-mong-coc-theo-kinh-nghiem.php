<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Xác định độ lún của móng cọc theo kinh nghiệm';
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tinhtoan-content">
    <div class="col-md-9">    
    <div class="text-center">
        <h1 class="text-uppercase" style="font-size: 25px;"><?= Html::encode($this->title) ?></h1>
    </div>
        <div id="result">

        </div>

        <p>Phương pháp này có thể xác định áp lực tại đáy móng tròn dưới tác động của tải trọng ngang và momen theo hai hướng x,y.</p>
        <p><u>Quy ước: </u></p>
        <ul>
            <li>Chiều dương của lực ngang Qx(y), tương ứng với chiều dương của của trục x (y);</li>
            <li>Chiều dương của momen Mx(y) xoay quanh trục x (y), tương ứng với chiều dương của trục y (x);</li>
            <li>Nếu trường hợp tính toán có tải trọng đứng, ngang hoặc momen uốn ngược chiều với hình 1 thì số liệu nhập vào bảng tính sẽ là giá trị âm.</li>
        </ul>
        <h3 style="font-size: 20px;">THÔNG SỐ ĐẦU VÀO</h3>
        <table>
            <tr>
                <td><strong>Tải trọng</strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Tải trọng thẳng đứng tác dụng lên cọc </td>
                <td style="width: 57px"> Q = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="500.0" step="0.01" name="varQ" id="varQ"> 
                </td>
                <td> kN </td>
            </tr>

            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng cọc</strong></td>
            </tr>
            <tr>
                <td>Tiết diện cọc </td>
                <td>  </td>
                <td>
                    <select id="check-tang-ham" class="form-control" name="check-tang-ham">
                        <option value="yes">&#10003;</option>
                        <option value="no">&#10005;</option>
                    </select>
                </td>
                <td>  </td>
            </tr>
            <tr>
                <td>Chiều rộng hoặc đường kính cọc </td>
                <td> D = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="0.6" step="0.01" name="varD1" id="varD1"> 
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Đường kính trong của cọc (cọc ống) </td>
                <td> D = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="0.6" step="0.01" name="varD2" id="varD2"> 
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều dài cọc </td>
                <td> L = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="20.0" step="0.01" name="varL" id="varL"> 
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Mô đun đàn hồi của vật liệu cọc </td>
                <td> E = </td>
                <td>
                    <input required class="form-control"  value="20.0"  name="varL" id="varL"> 
                </td>
                <td> kPa </td>
            </tr>
            <tr>
                <td>Chiều rộng của nhóm cọc </td>
                <td> B<sub>g </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="2.0" step="0.01" name="varL" id="varL"> 
                </td>
                <td> m </td>
            </tr>
        </table>
        <div class="text-center" style="margin-top: 10px">
            <img src="/images/02/day-mong-tron.png" alt="Hình 1. Quy ước hướng của tải trọng tác dụng và kích thước hình học móng" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Quy ước hướng của tải trọng tác dụng và kích thước hình học móng</i></p>

        <div class="checkbox">
                <label>
                    <input type="checkbox" id="newTabResult" value="">
                    Mở kết quả trên tab mới
                </label>
            </div>
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
            newTabResult = $("#newTabResult");
            if (newTabResult[0].checked == false) {
                $('#result').html('<div class="alert alert-success" role="alert">Báo cáo của bạn đã sẵn sàng để tải xuống. <a href="' + rs.filePath + '">Tải xuống</a></div>')
                $('#luot_tinh').html(rs.luot_tinh)
            } else {
                window.open('/tinh-toan/result?filePath='+rs.filePath,'_blank');
            }
        });
    }
</script>