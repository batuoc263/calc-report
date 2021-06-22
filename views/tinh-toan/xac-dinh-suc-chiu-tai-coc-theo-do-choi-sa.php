<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Xác định sức chịu tải của cọc theo số liệu thử động cọc bằng búa đóng với độ chối dư thực tế';
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tinhtoan-content">
    <div class="col-md-9">    
    <div class="text-center">
        <h1 class="text-uppercase" style="font-size: 25px;"><?= Html::encode($this->title) ?> S<sub>a</sub></h1>
    </div>
        <div id="result">

        </div>

        <p><i>Phương pháp tính toán dựa theo TCVN 10304:2014 Móng cọc – Tiêu chuẩn thiết kế, mục 7.3.4. Xác định sức chịu tải của cọc bằng thí nghiệm hiện trường dựa trên số liệu thử động cọc bằng búa đóng với độ chối dư thực tế. Trường hợp tính toán cho độ chối dư thực tế S<sub>a</sub>, hạ cọc bằng phương pháp đóng.</i></p>

        <h3 style="font-size: 20px;" class="text-center">THÔNG SỐ ĐẦU VÀO</h3>
        <table class="input-table">
            <tr>
                <td><strong>Đặc trưng cọc</strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Độ chối dư thực tế, lấy bằng chuyển vị của cọc do một nhát búa đập hoặc sau một phút rung </td>
                <td style="width: 70px"> S<sub>a</sub>= </td>
                <td style="width: 200px">
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="0.0018" name="varSa" id="varSa">
                </td>
                <td> m </td>
            </tr>
            <tr class="sa_be">
                <td>Độ chối đàn hồi của cọc (chuyển vị đàn hồi của đất và của cọc) xác định bằng máy đo chuyển vị </td>
                <td> S<sub>el</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="0.0006" name="varSel" id="varSel">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Tiết diện cọc </td>
                <td> </td>
                <td>
                    <select name="tiet_dien_coc" id="tiet_dien_coc" class="form-control" onchange="tietdien_changed(this.value)" required="required">
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
                <td> a(D) = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="0.30" name="varAD" id="varAD">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Đường kính trong của cọc (cho cọc ống) </td>
                <td> d = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" disabled value="-" name="varD" id="varD">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Diện tích tiết diện ngang thân cọc (không tính tại mũi cọc) </td>
                <td> A = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" disabled value="" name="varA" id="varA">
                </td>
                <td> m<sup>2</sup> </td>
            </tr>
            <tr class="sa_be">
                <td>Diện tích tiếp xúc giữa thân cọc với đất </td>
                <td> A<sub>f</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="10.00" name="varAf" id="varAf" data-toggle="tooltip" data-html="true" data-container="body" title="<p>π*D*L nếu cọc tròn, cọc ống</p><p>4*a*L nếu cọc vuông</p>">
                </td>
                <td> m<sup>2</sup> </td>
            </tr>
            <tr class="sa_lon">
                <td>Hệ số phụ thuộc vào vật liệu làm cọc </td>
                <td> &eta; = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="1500" name="varEta" id="varEta" data-toggle="tooltip" data-html="true" data-container="body" title="<p>Cọc BTCT: 1500</p><p>Cọc gỗ: 1000</p>">
                </td>
                <td> - </td>
            </tr>
            <tr class="sa_lon">
                <td>Hệ số phụ thuộc vào đất dưới mũi cọc (búa đóng lấy bằng 1)</td>
                <td> M = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="1.0" name="varM" id="varM">
                </td>
                <td> - </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng búa</strong></td>
            </tr>
            <tr>
                <td>Loại búa </td>
                <td colspan="2">
                    <select name="loaibua" id="loaibua" onchange="auto_tinh()" class="form-control" required="required">
                        <?php
                        foreach ($loaibua_arr as $key => $value) {
                            echo "<option value='$key'>$value</option>";
                        }
                        ?>
                    </select>
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td>Trọng lượng quả búa </td>
                <td> G = </td>
                <td>
                    <input class="form-control" required onblur="auto_tinh()" pattern="[0-9]*.[0-9]+" value="30.00" name="varG" id="varG">
                </td>
                <td> kN </td>
            </tr>
            <tr>
                <td>Chiều cao rơi thực tế của quả búa </td>
                <td> H = </td>
                <td>
                    <input class="form-control" required onblur="auto_tinh()" pattern="[0-9]*.[0-9]+" value="1.80" name="varH" id="varH">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều cao bật lần thứ nhất của quả búa diezen (búa khác h = 0 m) </td>
                <td> h = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.00" name="varh" id="varh" data-toggle="tooltip" data-html="true" data-container="body" title="<p>Búa dạng cân: 0.6m</p><p>Búa dạng ống: 0.4m</p><p>Búa dạng khác: 0.0m</p>">
                </td>
                <td> m </td>
            </tr>
            <tr class="sa_lon">
                <td>Khối lượng của búa máy hay búa rung </td>
                <td> m<sub>1</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="5.00" name="varm1" id="varm1">
                </td>
                <td> tấn </td>
            </tr>
            <tr>
                <td>Khối lượng của cọc và đệm đầu cọc </td>
                <td> m<sub>2</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="2.70" name="varm2" id="varm2">
                </td>
                <td> tấn </td>
            </tr>
            <tr class="sa_lon">
                <td>Trọng lượng cọc dẫn (khi dùng búa rung m = 0) </td>
                <td> m<sub>3</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.00" name="varm3" id="varm3">
                </td>
                <td> tấn </td>
            </tr>
            <tr class="sa_be">
                <td>Khối lượng quả búa </td>
                <td> m<sub>4</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="3.00" disabled name="varm4" id="varm4">
                </td>
                <td> tấn </td>
            </tr>
            <tr class="sa_lon">
                <td>Hệ số phục hồi xung kích </td>
                <td> &epsilon;<sup>2</sup> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.20" name="varEpsilon_sqr" id="varEpsilon_sqr" data-toggle="tooltip" data-html="true" data-container="body" title="<p>Cọc BTCT có dùng đệm đầu cọc bằng gỗ: 0,2</p>">
                </td>
                <td> - </td>
            </tr>
        </table>
        

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

        data = {
            _token: CSRF_TOKEN,
            varSa: $('#varSa').val(),
            varSel: $('#varSel').val(),
            tiet_dien_coc: $('#tiet_dien_coc').val(),
            varAD: $('#varAD').val(),
            varD: $('#varD').val(),
            varA: $('#varA').val(),
            varAf: $('#varAf').val(),
            varEta: $('#varEta').val(),
            varM: $('#varM').val(),
            loaibua: $('#loaibua').val(),
            varG: $('#varG').val(),
            varH: $('#varH').val(),
            varh: $('#varh').val(),
            varm1: $('#varm1').val(),
            varm2: $('#varm2').val(),
            varm3: $('#varm3').val(),
            varm4: $('#varm4').val(),
            varEpsilon_sqr: $('#varEpsilon_sqr').val()
        };

        $.ajax({
            method: "POST",
            url: "/tinh-toan/xac-dinh-suc-chiu-tai-coc-theo-do-choi-sa",
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
            $('#varD').prop('disabled', false);
        } else {
            $('#varD').val("-");
            $('#varD').prop('disabled', true);
        }
        auto_tinh();
    }

    
    function auto_tinh() {
        varSa = $('#varSa').val();
        if (varSa < 0.002) {
            $('.sa_lon').hide();
            $('.sa_be').show();
        } else {
            $('.sa_lon').show();
            $('.sa_be').hide();
        }

        varAD = $('#varAD').val();
        if (varAD != '') {
            tietdien = $('#tiet_dien_coc').val(); //tron - vuong - ong
            console.log("tiet dien = " + tietdien);

            if (tietdien == 1) {
                varA = 0.25 * Math.PI * Math.pow(varAD, 2);
            }
            if (tietdien == 2) {
                varA = Math.pow(varAD, 2);
            }
            if (tietdien == 3) {
                varD = $('#varD').val()
                varA = 0.25 * Math.PI * (Math.pow(varAD, 2) - Math.pow(varD, 2));
            }

            console.log("A = " + varA);
            $('#varA').val(varA.toFixed(3))

            console.log("Input A = " + $('#varA').val());
        }
        
        varG = $('#varG').val();
        varm4 = varG/10
        $('#varm4').val(varm4.toFixed(1))
    }

    window.onload = function() {
        $('.sa_lon').hide();
        $('#varAf').popover({
            trigger: 'focus hover'
        });
        $('#varEta').popover({
            trigger: 'focus hover'
        });
        $('#varM').popover({
            trigger: 'focus hover'
        });
        $('#varh').popover({
            trigger: 'focus hover'
        });
        $('#varEpsilon_sqr').popover({
            trigger: 'focus hover'
        });
        auto_tinh();
    }
</script>