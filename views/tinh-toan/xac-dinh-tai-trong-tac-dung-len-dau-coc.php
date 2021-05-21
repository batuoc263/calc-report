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
    <div class="col-md-9">    
    <div class="text-center">
        <h1 class="text-uppercase" style="font-size: 25px;"><?= Html::encode($this->title) ?></h1>
    </div>
        <div id="result">

        </div>

        <p>Phương pháp tính toán dựa theo TCVN 10304:2014 Móng cọc – Tiêu chuẩn thiết kế, mục 7.1.13. Xác định giá trị tải trọng truyền lên cọc.</p>
        </br>
        <h3 style="font-size: 20px;">THÔNG SỐ ĐẦU VÀO</h3>
        <table>
            <tr>
                <td><strong>Tải trọng tác dụng tại cao trình đáy đài </strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Tải trọng thẳng đứng  </td>
                <td style="width: 50px"> &#966; <sub> N </sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" lang="en" value="5000" step="0.1" name="varPhiII" id="varPhiII"> kN
                </td>
            </tr>
            <tr>
                <td>Mômen uốn, xoay quanh trục  x tại cao trình đáy đài </td>
                <td> M<sub> x </sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="120" step="0.1" name="varCII" id="varCII"> kN.m
                </td>
            </tr>
            <tr>
                <td>Mômen uốn, xoay quanh trục y tại cao trình đáy đài </td>
                <td> M <sub> y </sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="150" step="0.1" name="varGamma1" id="varGamma1"> kN.m
                </td>
            </tr>
            
        </table>
        <div class="text-center" style="margin-top: 10px">
            <img src="/images/06/quyuochuong.png" alt="Hình 1. Quy ước hướng" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Quy ước hướng và vị trí đặt lực của tải trọng tác dụng</i></p>

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
    $(document).ready(function() {
        $("#check-day-noi").change(function() { showItem("#check-day-noi", ".check-day-noi-item"); });
        $("#check-tang-ham").change(function() { showItem("#check-tang-ham", ".check-tang-ham-item"); });
    });

    function showItem(className, itemName) {
        
        var selected_option = $(className).val();

        if (selected_option == 'yes') {
            $(itemName).show();
        } else {
            $(itemName).hide();
        }
            
        
    }

    function tinhtoan() {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        varPhiII = $('#varPhiII').val()
        varCII = $('#varCII').val()
        varGamma1 = $('#varGamma1').val()
        varGamma2 = $('#varGamma2').val()
        varGammaS = $('#varGammaS').val()
        varE = $('#varE').val()
        varH = $('#varH').val()
        varB = $('#varB').val()
        varH1 = $('#varH1').val()
        varH2 = $('#varH2').val()
        varM1 = $('#varM1').val()
        varM2 = $('#varM2').val()
        varKtc = $('#varKtc').val()
        check_day_noi = $("#check-day-noi").val()
        check_tang_ham = $("#check-tang-ham").val()

        data= {
                _token: CSRF_TOKEN,
                varPhiII: varPhiII,
                varCII: varCII,
                varGamma1: varGamma1,
                varGamma2: varGamma2,
                varGammaS: varGammaS,
                varE: varE,
                varH: varH,
                varB: varB,
                varH1: varH1,
                varH2: varH2,
                varM1: varM1,
                varM2: varM2,
                varKtc: varKtc,
                check_day_noi: check_day_noi,
                check_tang_ham: check_tang_ham
            };

        console.log(data);
        $.ajax({
            method: "POST",
            url: "/tinh-toan/xac-dinh-ap-luc-tinh-toan-tac-dung-len-nen",
            data: data
        }).done(function(msg) {
            console.log(msg)
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