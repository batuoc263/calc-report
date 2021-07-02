<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Xác định sức chịu tải của cọc chống';
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

        <p><i>Phương pháp tính toán dựa theo TCVN 10304:2014 Móng cọc – Tiêu chuẩn thiết kế, mục 7.2.1. Sức chịu tải của cọc chống theo chỉ tiêu cơ lý đất, đá. Ngoài ra, so sánh kết quả nhận được với sức chịu tải của cọc theo vật liệu nhằm tối ưu hóa kích thước cọc thiết kế.</i></p>

        <h3 style="font-size: 20px;" class="text-center">THÔNG SỐ ĐẦU VÀO</h3>
        <table class="input-table">
            <tr>
                <td><strong>Đặc trưng cọc</strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Loại cọc </td>
                <td style="width: 70px"> </td>
                <td style="width: 200px">
                    <select name="loai_coc" id="loai_coc" class="form-control" onchange="loaicoc_changed(this.value)" required="required">
                        <?php
                            foreach ($loaicoc_arr as $key => $value) {
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
                <td> a(D)= </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="0.60" step="0.01" name="varAD" id="varAD">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Đường kính trong của cọc (nếu là cọc ống) </td>
                <td> d = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" disabled value="-" step="0.01" name="varD" id="varD">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều sâu ngàm cọc vào đá </td>
                <td> l<sub>d</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.0" step="0.01" name="varLd" id="varLd">
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Đường kính ngoài của phần cọc ngàm vào đá </td>
                <td> d<sub>f</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" onblur="auto_tinh()" value="0.60" step="0.01" name="varDf" id="varDf">
                </td>
                <td> m </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><u>Vật liệu cọc</u></td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Cấp độ bền bê tông </td>
                <td> </td>
                <td>
                    <select name="cap_do_ben" id="cap_do_ben" onchange="auto_tinh()" class="form-control" required="required">
                        <?php
                        foreach ($cap_do_ben_arr as $key => $value) {
                            echo "<option value='$key'>$key</option>";
                        }
                        ?>
                    </select>
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Loại thép </td>
                <td> </td>
                <td>
                    <select name="loai_thep" id="loai_thep" onchange="auto_tinh()" class="form-control" required="required">
                        <?php
                        foreach ($loai_thep_arr as $key => $value) {
                            echo "<option value='$key'>$key</option>";
                        }
                        ?>
                    </select>
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Số lượng thanh thép </td>
                <td> n = </td>
                <td>
                    <input class="form-control" required onblur="auto_tinh()" pattern="[0-9]*.[0-9]+" value="8" step="0.01" name="varN" id="varN">
                </td>
                <td> thanh </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Đường kính thanh thép </td>
                <td> d<sub>t</sub> = </td>
                <td>
                    <input class="form-control" required onblur="auto_tinh()" pattern="[0-9]*.[0-9]+" value="25" step="0.01" name="varDt" id="varDt">
                </td>
                <td> mm </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Diện tích mặt cắt ngang của thép </td>
                <td> A<sub>s</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.0039" step="0.01" disabled name="varAs" id="varAs">
                </td>
                <td> m <sup>2</sup> </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Diện tích mặt cắt ngang của bê tông </td>
                <td> A<sub>b</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.283" step="0.01" disabled name="varAb" id="varAb">
                </td>
                <td> m <sup>2</sup> </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Cường độ chịu nén của thép </td>
                <td> R<sub>sc</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="345000" step="0.01" disabled name="varRsc" id="varRsc">
                </td>
                <td> kPa </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Cường độ chịu nén của bê tông </td>
                <td> R<sub>b</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="6000" step="0.01" disabled name="varRb" id="varRb">
                </td>
                <td> kPa </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Hệ số điều kiện làm việc của cọc </td>
                <td> &gamma;<sub>c</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.00" step="0.01" onblur="auto_tinh()" name="varGammaC" id="varGammaC" data-toggle="tooltip" data-html="true" data-container="body" title="<p>1.0 - a(D) > 0.2 m</p><p>0.9 - a(D) < 0.2 m</p>">
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Hệ số uốn dọc, đối với cọc đài thấp lấy bằng 1 </td>
                <td> &#966; = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.00" step="0.01" onblur="auto_tinh()" name="varPhi" id="varPhi">
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Hệ số chiết giảm điều kiện làm việc của bê tông </td>
                <td> &gamma;<sub>cb</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="0.85" step="0.01" onblur="auto_tinh()" name="varGammaCb" id="varGammaCb" data-toggle="tooltip" data-html="true" data-container="body" title="<p>1.00 - Đóng-ép</p><p>0.85 - Khoan nhồi, barrette</p>">
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Hệ số chiết giảm thêm kể đến phương pháp thi công cọc </td>
                <td> &gamma;'<sub>cb</sub> = </td>
                <td>
                    <input class="form-control" data-toggle="tooltip" data-html="true" data-container="body" title="<p style='font-size:13px;text-align:justify;'>Đối với cọc thi c&ocirc;ng tại chổ c&oacute; kể đến việc đổ b&ecirc; t&ocirc;ng trong khoảng kh&ocirc;ng gian chật hẹp của hố v&agrave; ống v&aacute;ch:</p><p style='font-size:13px;'>1.0 - MNN thấp hơn mũi cọc;</p><p style='font-size:13px;'>0.9 - D&ugrave;ng ống v&aacute;ch hoặc guồng xoắn rỗng ruột;</p><p style='font-size:13px;'>0.8 - Dưới nước, c&oacute; d&ugrave;ng ống v&aacute;ch giữ th&agrave;nh;</p><p style='font-size:13px;'>0.7 - Dung dịch khoan, dưới nước, kh&ocirc;ng d&ugrave;ng ống v&aacute;ch giữ th&agrave;nh</p>" required pattern="[0-9]*.[0-9]+" value="0.80" step="0.01" onblur="auto_tinh()" name="varGammaCbsub" id="varGammaCbsub">
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Hệ số điều kiện làm việc của thép </td>
                <td> &gamma;<sub>s</sub> = </td>
                <td>
                    <input class="form-control" required pattern="[0-9]*.[0-9]+" value="1.00" step="0.01" onblur="auto_tinh()" name="varGammaS" id="varGammaS">
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td>Sức chịu tải của cọc theo vật liệu được xác định theo công thức sau: </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    <i>R<sub>vl</sub> = &gamma;<sub>c</sub> &#966; (&gamma;<sub>cb</sub> &gamma;'<sub>cb</sub> R<sub>b</sub> A<sub>b</sub> + &gamma;<sub>s</sub> R<sub>sc</sub> A<sub>s</sub>) </i>
                </td>
                <td></td>
                <td>
                    <input class="form-control" required disabled style="color: blue; font-weight: bold" pattern="[0-9]*.[0-9]+" step="0.01" name="varRvl" id="varRvl">
                </td>
                <td> kN </td>
            </tr>
            <!-- ===== -->
            <tr>
                <td><strong>Hệ số điều kiện làm việc khác</strong></td>
            </tr>
            <tr>
                <td>Hệ số tin cậy của đất </td>
                <td> &gamma;<sub>g</sub> = </td>
                <td>
                    <input class="form-control" required value="1.4" pattern="[0-9]*.[0-9]+" step="0.01" name="varGammaG" id="varGammaG">
                </td>
                <td> - </td>
            </tr>
            <!-- ===== -->
            <tr>
                <td><strong>Đặc trưng đất nền</strong></td>
            </tr>
            <tr>
                <td>Trị tiêu chuẩn giới hạn bền chịu nén một trục của đá ở trạng thái bão hòa nước, được xác định theo kết quả thử mẫu (nguyên khối) trong phòng thí nghiệm </td>
                <td> R<sub>c,n</sub> = </td>
                <td>
                    <input class="form-control" required value="31.30" pattern="[0-9]*.[0-9]+" step="0.01" name="varRcn" id="varRcn">
                </td>
                <td> MPa </td>
            </tr>
            <tr>
                <td>Chỉ số chất lượng đá </td>
                <td> RQD = </td>
                <td>
                    <input class="form-control" required value="50" pattern="[0-9]*.[0-9]+" name="varRQD" id="varRQD" data-toggle="tooltip" data-html="true" data-container="body" title="<img width='250px' src='/images/08/chi_so_chat_luong_da.png' alt='Chỉ số chất lượng đá'>">
                </td>
                <td> % </td>
            </tr>
            
            <input type="hidden" name="varA" id="varA" class="form-control" value="0.283">
            

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

        data = {
            _token: CSRF_TOKEN,
            loai_coc: $('#loai_coc').val(),
            tiet_dien_coc: $('#tiet_dien_coc').val(),
            varAD: $('#varAD').val(),
            varD: $('#varD').val(),
            varLd: $('#varLd').val(),
            varDf: $('#varDf').val(),
            cap_do_ben: $('#cap_do_ben').val(),
            loai_thep: $('#loai_thep').val(),
            varN: $('#varN').val(),
            varDt: $('#varDt').val(),
            varAs: $('#varAs').val(),
            varAb: $('#varAb').val(),
            varRsc: $('#varRsc').val(),
            varRb: $('#varRb').val(),
            varGammaC: $('#varGammaC').val(),
            varPhi: $('#varPhi').val(),
            varGammaCb: $('#varGammaCb').val(),
            varGammaCbsub: $('#varGammaCbsub').val(),
            varGammaS: $('#varGammaS').val(),
            varRvl: $('#varRvl').val(),
            varGammaG: $('#varGammaG').val(),
            varRcn: $('#varRcn').val(),
            varRQD: $('#varRQD').val(),
            varA: $('#varA').val()
        };

        $.ajax({
            method: "POST",
            url: "/tinh-toan/xac-dinh-suc-chiu-tai-coc-chong",
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
            $('#varD').prop('disabled', true);
        }
        auto_tinh();
    }

    function loaicoc_changed(value) {
        if (value == 1) {
            $('#varRcn').prop('disabled', false);
            $('#varRQD').prop('disabled', false);
        } else {
            $('#varRcn').prop('disabled', true);
            $('#varRQD').prop('disabled', true);
        }
        auto_tinh();
    }

    
    function auto_tinh() {
        varAD = $('#varAD').val();
        if (varAD != '') {
            tietdien = $('#tiet_dien_coc').val(); //tron - vuong - ong
            console.log("tiet dien = " + tietdien);

            if (tietdien == 1) {
                varAb = 0.25 * Math.PI * Math.pow(varAD, 2);
            }
            if (tietdien == 2) {
                varAb = Math.pow(varAD, 2);
            }
            if (tietdien == 3) {
                varD = $('#varD').val()
                varAb = 0.25 * Math.PI * (Math.pow(varAD, 2) - Math.pow(varD, 2));
            }

            console.log("Ab = " + varAb);
            $('#varAb').val(varAb.toFixed(3))

            console.log("Input Ab = " + $('#varAb').val());
        }
        ////////
        varDf = $('#varDf').val();
        if (varDf != '') {
            tietdien = $('#tiet_dien_coc').val(); //tron - vuong - ong
            console.log("tiet dien = " + tietdien);

            if (tietdien == 1) {
                varA = 0.25 * Math.PI * Math.pow(varDf, 2);
            }
            if (tietdien == 2) {
                varA = Math.pow(varDf, 2);
            }
            if (tietdien == 3) {
                varD = $('#varD').val()
                varA = 0.25 * Math.PI * (Math.pow(varDf, 2) - Math.pow(varD, 2));
            }

            console.log("Ab = " + varA);
            $('#varA').val(varA.toFixed(3))

            console.log("Input A = " + $('#varA').val());
        }
        //////////
        varN = $('#varN').val();
        varDt = $('#varDt').val() / 1000;

        if ((varN != '') && (varDt != '')) {
            varAs = varN * 0.25 * Math.PI * Math.pow(varDt, 2);
            console.log("varAs = "+varAs);
            $('#varAs').val(varAs.toFixed(4))
        }
        //////////
        dobenObj = JSON.parse(JSON.stringify(<?= $cap_do_ben_json ?>));
        doben = $('#cap_do_ben').val();
        varRb = dobenObj[doben].Rb
        $('#varRb').val(varRb);
        //////////
        loaithepObj = JSON.parse(JSON.stringify(<?= $loai_thep_json ?>));
        loaithep = $('#loai_thep').val();
        varRsc = loaithepObj[loaithep].Rsc
        $('#varRsc').val(varRsc);
        ////////
        varGammaC = $('#varGammaC').val()
        varPhi = $('#varPhi').val()
        varGammaCb = $('#varGammaCb').val()
        varGammaCbsub = $('#varGammaCbsub').val()

        varGammaS = $('#varGammaS').val()
        varRsc = $('#varRsc').val()
        
        varRvl = varGammaC * varPhi * (varGammaCb*varGammaCbsub*varRb*varAb + varGammaS*varRsc*varAs)
        console.log(varRvl);
        $('#varRvl').val(varRvl.toFixed(0))
    }

    window.onload = function() {
        $('#varGammaC').popover({
            trigger: 'focus hover'
        });
        $('#varGammaCb').popover({
            trigger: 'focus hover'
        });
        $('#varGammaCbsub').popover({
            trigger: 'focus hover'
        });
        $('#varRQD').popover({
            trigger: 'focus hover'
        });
        auto_tinh();
    }
</script>