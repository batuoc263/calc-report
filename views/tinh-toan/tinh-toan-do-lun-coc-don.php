<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Tính toán độ lún cọc đơn';
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

        <p class="text-center"><i>Phương pháp tính toán dựa theo TCVN 10304:2014 Móng cọc – Tiêu chuẩn thiết kế, mục 7.4.2.</i></p>
        <p class="text-center"><i>Tính toán độ lún cọc đơn.</i></p>

        <h3 style="font-size: 20px;" class="text-center">THÔNG SỐ ĐẦU VÀO</h3>
        <table class="input-table">
            <tr>
                <td><strong>Tải trọng tác dụng (TTGH II)</strong></td>
            </tr>
            <tr>
                <td>Tải trọng thẳng đứng tác dụng lên cọc </td>
                <td> N = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.000" name="varN" id="varN">
                </td>
                <td> MN </td>
            </tr>
            <tr>
                <td><strong>Đặc trưng cọc</strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Cọc treo đơn </td>
                <td style="width: 70px"> </td>
                <td style="width: 200px">
                    <select name="coc_treo_don" id="coc_treo_don" onchange="coctreodon_changed(this.value)" class="form-control" required="required">
                        <?php
                            foreach ($coctreodon_arr as $key => $value) {
                                echo "<option value='$key'>$value</option>";
                            }
                        ?>
                    </select>
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td>Tiết diện cọc </td>
                <td> </td>
                <td>
                    <select name="tiet_dien_coc" id="tiet_dien_coc" onchange="tietdien_changed(this.value)" class="form-control" required="required">
                        <?php
                            foreach ($tietdiencoc_arr as $key => $value) {
                                echo "<option value='$key'>$value</option>";
                            }
                        ?>
                    </select>
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td>Cạnh cọc vuông (hoặc đường kính ngoài của cọc tròn, ống) </td>
                <td> d = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.50" name="varD" id="varD">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Đường kính trong của cọc (cho cọc ống) </td>
                <td> d<sub>t</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" disabled value="-" name="varDt" id="varDt">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Đường kính mũi mở rộng (cho cọc mở rộng mũi) </td>
                <td> d<sub>b</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" disabled value="-" name="varDb" id="varDb">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều dài cọc </td>
                <td> l = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="20.0" name="varL" id="varL">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Mô đun đàn hồi của vật liệu cọc </td>
                <td> E = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="30000" name="varE" id="varE">
                </td>
                <td> MPa </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng đất nền</strong></td>
            </tr>
            <tr>
                <td>Môđun biến dạng của đất dọc thân cọc l </td>
                <td> E<sub>1</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="18.0" name="varE1" id="varE1">
                </td>
                <td> MPa </td>
            </tr>
            <tr>
                <td>Môđun biến dạng của đất được lấy trong phạm vi bằng 0,5l, từ độ sâu l đến độ sâu 1,5l kể từ mũi cọc </td>
                <td> E<sub>2</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="22.0" name="varE2" id="varE2">
                </td>
                <td> MPa </td>
            </tr>
            <tr>
                <td>Hệ số poisson của đất dọc thân cọc l </td>
                <td> v<sub>1</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.35" name="varV1" id="varV1">
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td>Hệ số poisson của đất được lấy trong phạm vi bằng 0,5l, từ độ sâu l đến độ sâu 1,5l kể từ mũi cọc </td>
                <td> v<sub>1</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.42" name="varV2" id="varV2">
                </td>
                <td> - </td>
            </tr>
        </table>
        <div class="text-center" style="margin-top: 10px">
            <img src="/images/15/tinh-lun-coc-don.png" alt="Hình 1. Sơ đồ tính lún cọc đơn không mở rộng mũi (trái) và mở rộng mũi (phải)" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Sơ đồ tính lún cọc đơn không mở rộng mũi (trái) và mở rộng mũi (phải)</i></p>
     

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
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Tên bài toán</strong></div>
            <div class="panel-body">
                <?php
                foreach ($menu as $key => $value) { ?>
                    <div>
                        <i class="collapse-btn fa fa-caret-right fa-fw"></i> <strong><?= $value['ten'] ?></strong> 
                    </div>

                    <ul>
                        <?php foreach ($value['children'] as $child) { ?>
                            <li><a href="<?= $child['duong_dan'] ?>"><?= $child['ten_bai_toan'] ?></a></li>
                        <?php } ?>
                    </ul>

                <?php    }
                ?>
            </div>
        </div>
    </div>

</div>

<script>
    function tinhtoan() {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        tietdien = $('#tiet_dien_coc').val();
        varD = $('#varD').val()
        if (tietdien == 1) {
            varA = 0.25 * Math.PI * Math.pow(varD, 2);
        }
        if (tietdien == 2) {
            varA = Math.pow(varD, 2);
        }
        if (tietdien == 3) {
            varDt = $('#varDt').val()
            varA = 0.25 * Math.PI * (Math.pow(varD, 2) - Math.pow(varDt, 2));
        }

        data = {
            _token: CSRF_TOKEN,
            varN: $('#varN').val(),
            coc_treo_don: $('#coc_treo_don').val(),
            tiet_dien_coc: $('#tiet_dien_coc').val(),
            varD: $('#varD').val(),
            varDt: $('#varDt').val(),
            varDb: $('#varDb').val(),
            varL: $('#varL').val(),
            varE: $('#varE').val(),
            varE1: $('#varE1').val(),
            varE2: $('#varE2').val(),
            varV1: $('#varV1').val(),
            varV2: $('#varV2').val(),
            varA: varA
        };

        console.log(data);

        $.ajax({
            method: "POST",
            url: "/tinh-toan/tinh-toan-do-lun-coc-don",
            data: data
        }).done(function(msg) {
            $(window).scrollTop(0); rs = JSON.parse(msg); 
            newTabResult = $("#newTabResult");
            if (newTabResult[0].checked == false) {
                $('#result').html('<div class="alert alert-success" role="alert">Báo cáo của bạn đã sẵn sàng để tải xuống. <a href="' + rs.filePath + '">Tải xuống</a></div>')
                $('#luot_tinh').html(rs.luot_tinh)
            } else {
                window.open('/tinh-toan/result?filePath=' + rs.filePath, '_blank');
            }
        });
    }

    function tietdien_changed(value) {
        if (value == 3) {
            $('#varDt').prop('disabled', false);
            $('#varDt').val('');
        } else {
            $('#varDt').prop('disabled', true);
            $('#varDt').val('-');
        }
    }

    function coctreodon_changed(value) {
        if (value == 1) {
            $('#varDb').prop('disabled', true);
            $('#varDb').val("-");
            $('#varE1').prop('disabled', false);
            $('#varV1').prop('disabled', false);
            $('#varE1').val('18.0');
            $('#varV1').val('0.35');
        } else {
            $('#varDb').prop('disabled', false);
            $('#varDb').val("0.80");
            $('#varE1').prop('disabled', true);
            $('#varV1').prop('disabled', true);
            $('#varE1').val('-');
            $('#varV1').val('-');
        }
    }

</script>