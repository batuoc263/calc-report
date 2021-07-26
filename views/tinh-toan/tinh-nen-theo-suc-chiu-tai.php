<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Tính nền theo sức chịu tải';
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

        <p class="text-center"><i>Phương pháp tính toán dựa theo TCVN 9362-2012 Thiết kế nền nhà và công trình, mục 4.7</i></p>
        <p class="text-center"><i>Tính nền theo sức chịu tải.</i></p>
        <p class="text-justify">Mục đích tính nền theo sức chịu tải (theo nhóm trạng thái) giới hạn thứ nhất là đảm bảo độ bền của nền và tính ổn định của nền đất (không phải đá), cũng như không cho phép móng trượt theo đáy và không cho phép lật vì sẽ dẫn đến sự chuyển vị đáng kể của từng móng hoặc của toàn bộ công trình và do đó công trình không thể sử dụng được.</p>

        <h3 style="font-size: 20px;" class="text-center">THÔNG SỐ ĐẦU VÀO</h3>
        <table class="input-table">
            <tr>
                <td><strong>Tải trọng tác dụng tại đáy móng (tính theo TTGH I)</strong></td>
            </tr>
            <tr>
                <td>Lực thẳng đứng </td>
                <td> F<sub>v</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1100" name="varFv" id="varFv">
                </td>
                <td> kN </td>
            </tr>
            <tr>
                <td>Lực ngang </td>
                <td> F<sub>h</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="70" name="varFh" id="varFh">
                </td>
                <td> kN </td>
            </tr>
            <tr>
                <td>Momen uốn, xoay quanh cạnh b</td>
                <td> M<sub>b</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0" name="varMb" id="varMb">
                </td>
                <td> kNm </td>
            </tr>
            <tr>
                <td>Momen uốn, xoay quanh cạnh l</td>
                <td> M<sub>l</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="88" name="varMl" id="varMl">
                </td>
                <td> kNm </td>
            </tr>
            <tr>
                <td><strong>Đặc trưng đất nền </strong></td>
            </tr>
            <tr>
                <td>Góc ma sát trong </td>
                <td> &phi;<sub>I</sub> =  </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="15.0" name="varphiI" id="varphiI">
                </td>
                <td> độ </td>
            </tr>
            <tr>
                <td>Lực dính đơn vị của đất nằm trực tiếp dưới đáy móng</td>
                <td> c<sub>I</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="6.0" step="1" name="varCI" id="varCI"> 
                </td>
                <td> kN/m<sup>2</sup> </td>
            </tr>
            <tr>
                <td>Trọng lượng thể tích của đất trên đáy móng </td>
                <td> &gamma;'<sub> I </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="17.0" step="0.1" name="varGammaIPhay" id="varGammaIPhay"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Trọng lượng thể tích của đất dưới đáy móng </td>
                <td> &gamma;<sub>I</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="19.0" step="0.1" name="varGammaI" id="varGammaI"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Chiều sâu mực nước ngầm </td>
                <td> MNN = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.5" name="varMNN" id="varMNN">
                </td>
                <td> m </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng hình học móng</strong></td>
            </tr>
            <tr>
                <td>Chiều rộng đáy móng </td>
                <td> b = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="2.40" name="varb" id="varb">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều dài đáy móng </td>
                <td> l = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="3.00" name="varl" id="varl">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều sâu đặt móng (phía áp lực đất bị động) </td>
                <td> h = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.00" name="varh" id="varh">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều sâu đặt móng (phía áp lực đất chủ động) </td>
                <td> h<sub>1</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.30" name="varh1" id="varh1">
                </td>
                <td> m </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng hình học móng</strong></td>
            </tr>
            <tr>
                <td>Hệ số tin cậy do cơ quan thiết kế quy định </td>
                <td> k<sub>tc</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.2" name="varktc" id="varktc" data-toggle="tooltip" data-html="true" data-container="body" title="Quy định tùy theo tính chất quan trọng của nhà hoặc công trình, ý nghĩa của nhà hoặc công trình khi tận dụng hết sức chịu tải của nền, mức độ nghiên cứu điều kiện đất đai và lấy không nhỏ hơn 1.2">
                </td>
                <td> - </td>
            </tr>
        </table>
        <div class="text-center" style="margin-top: 10px">
            <img src="/images/25/h1.png" alt="Hình 1. Sơ đồ tính sức chịu tải của nền" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Sơ đồ tính sức chịu tải của nền</i></p>
     

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
                            <li <?= $child['duong_dan'] == $dmtt->duong_dan ? 'class="active_bt"' : '' ?> ><a href="<?= $child['duong_dan'] ?>"><?= $child['ten_bai_toan'] ?></a></li>
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

        data = {
            _token: CSRF_TOKEN,
            varFv: $('#varFv').val(),
            varFh: $('#varFh').val(),
            varMb: $('#varMb').val(),
            varMl: $('#varMl').val(),
            varphiI: $('#varphiI').val(),
            varCI: $('#varCI').val(),
            varGammaIPhay: $('#varGammaIPhay').val(),
            varGammaI: $('#varGammaI').val(),
            varMNN: $('#varMNN').val(),
            varb: $('#varb').val(),
            varl: $('#varl').val(),
            varh: $('#varh').val(),
            varh1: $('#varh1').val(),
            varktc: $('#varktc').val()
        };

        console.log(data);

        $.ajax({
            method: "POST",
            url: "/tinh-toan/tinh-nen-theo-suc-chiu-tai",
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

    window.onload = function() {
        $('#varktc').popover({
            trigger: 'focus hover'
        });
    }
</script>