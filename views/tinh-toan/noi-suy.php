<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Nội suy tuyến tính';
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

        <p class="text-justify">Nội suy là một công cụ toán học cơ bản được ứng dụng rộng rãi trong nhiều ngành như công nghệ thông tin, kinh tế, tài chính, xây dựng, y học và những ngành cần xử lý dữ liệu số khác, v.v. Do đó bảng tính nội suy trực tuyến dưới đây nhằm hỗ trợ một phần nào đó cho các bạn sinh viên, kỹ sư xây dựng trong công việc</p>

        <h3 style="font-size: 20px;" class="text-center">Nội suy 1 chiều</h3>
        <div class="entry-content entry clearfix">

            <div class="row" style="margin-top: 5px">
                <div class="col-xs-4">
                    <input type="text" style="border-color: green" class="form-control" oninput="reset('x11')" id="x11" value="10" placeholder="X11">
                </div>

                <div class="col-xs-4 text-center">
                    &lt;====&gt;
                </div>

                <div class="col-xs-4">
                    <input type="text" style="border-color: green" class="form-control" oninput="reset('x12')" id="x12" value="100" placeholder="X12">

                </div>
                <div style="clear: both;"></div>
            </div>


            <div class="row" style="margin-top: 5px">
                <div class="col-xs-4">
                    <input type="text" class="form-control" oninput="nstc()" id="x21" style="border-color: red" placeholder="Giá trị cần nội suy">
                </div>

                <div class="col-xs-4 text-center">
                    &lt;====&gt;
                </div>

                <div class="col-xs-4">
                    <input type="text" class="form-control" oninput="nsnc()" id="x22" style="border-color: red" placeholder="Giá trị cần nội suy">

                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="row" style="margin-top: 5px">
                <div class="col-xs-4">
                    <input type="text" style="border-color: green" class="form-control" oninput="reset('x31')" id="x31" value="20" placeholder="X31">
                </div>

                <div class="col-xs-4 text-center">
                    &lt;====&gt;
                </div>

                <div class="col-xs-4">
                    <input type="text" style="border-color: green" class="form-control" oninput="reset('x32')" id="x32" value="200" placeholder="X32">

                </div>
                <div style="clear: both;"></div>
            </div>


            <br>
            <br>

            <h3 style="font-size: 20px;" class="text-center">Nội suy 2 chiều</h3>
            <div class="entry-content entry clearfix">
                <div class="table-is-responsive">
                    <table id="ns2c">
                        <form id="fns">

                        <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cx1')" name="pp[cx1]" id="cx1" value="" placeholder="X1">
                                </td>
                                <td>
                                    <input type="text" style="border-color: red" class="form-control" oninput="resetx('cx')" name="pp[cx]" id="cx" value="" placeholder="Giá trị cần nội suy">

                                </td>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cx2')" name="pp[cx2]" id="cx2" value="" placeholder="X2">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cy1')" name="pp[cy1]" id="cy1" value="" placeholder="Y1">

                                </td>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cx1y1')" name="pp[cx1y1]" id="cx1y1" value="" placeholder="Giá trị tại X1 và Y1">

                                </td>
                                <td class="text-center"><span id="xx1" class="label label-primary">0</span></td>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cx2y1')" name="pp[cx2y1]" id="cx2y1" value="" placeholder="Giá trị tại X2 và Y1">

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" style="border-color: red" class="form-control" oninput="resetx('cy')" name="pp[cy]" id="cy" value="" placeholder="Giá trị cần nội suy">

                                </td>
                                <td class="text-center"><span id="yy1" class="label label-success">0</span></td>
                                <td class="text-center"><span id="kq" class="label label-danger">0</span></td>
                                <td class="text-center"><span id="yy2" class="label label-success">0</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cy2')" name="pp[cy2]" id="cy2" value="" placeholder="Y2">

                                </td>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cx1y2')" name="pp[cx1y2]" id="cx1y2" value="" placeholder="Giá trị tại X1 và Y2">

                                </td>
                                <td class="text-center"><span id="xx2" class="label label-primary">0</span></td>
                                <td>
                                    <input type="text" style="border-color: green" class="form-control" oninput="resetx('cx2y2')" name="pp[cx2y2]" id="cx2y2" value="" placeholder="Giá trị tại X2 và Y2">

                                </td>
                            </tr>

                        </tbody>
                        </form>

                        <tfoot>
                            <tr>
                                <td style="text-align: center;">
                                    <button onclick="datlaibs()" type="button" class="btn btn-warning btn-block">Đặt lại</button>
                                </td>
                                <td></td>
                                <td></td>
                                <td style="text-align: center;">
                                    <button onclick="noisuy2c()" type="button" class="btn btn-success btn-block">NỘI SUY</button>
                                </td>

                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>

        <hr>
        <div class="row" style="margin-top: 5px">
            <div class="col-md-3 col-md-offset-6">Lượt tính: <span id="luot_tinh"><?= $dmtt->luot_giai ?></span></div>
            <div class="col-md-3 text-right">

                <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="small">
                    <a data-label="Facebook" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="fb-xfbml-parse-ignore">
                        <img src="/images/fbshare.PNG" alt="Share Facebook">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?= $this->render('_menu_sidebar', [
            'menu' => $menu,
            'dmtt' => $dmtt,
        ]) ?>
    </div>

</div>

<script type="text/javascript">
                function datlaibs() {


                    jQuery("#cx1").val('');
                    setCookie('cx1', '');
                    jQuery("#cx2").val('');
                    setCookie('cx2', '');
                    jQuery("#cy1").val('');
                    setCookie('cy1', '');
                    jQuery("#cy2").val('');
                    setCookie('cy2', '');
                    jQuery("#cx1y1").val('');
                    setCookie('cx1y1', '');
                    jQuery("#cx1y2").val('');
                    setCookie('cx1y2', '');
                    jQuery("#cx2y1").val('');
                    setCookie('cx2y1', '');
                    jQuery("#cx2y2").val('');
                    setCookie('cx2y2', '');


                }

                function resetx(x) {


                    setCookie(x, jQuery("#" + x).val());

                }

                function noisuy2c() {
                    data = jQuery('#fns').serialize();
                    jQuery.post('/tinh-toan/noi-suy', data, function(d) {

                        dt = JSON.parse(d);
                        if (dt.loi) {
                            alert(dt.loi);

                        } else {

                            jQuery("#xx1").html(dt.xx1);
                            jQuery("#xx2").html(dt.xx2);
                            jQuery("#yy1").html(dt.yy1);
                            jQuery("#yy2").html(dt.yy2);
                            jQuery("#kq").html(dt.kq);
                        }

                    });

                }

                function setCookie(cname, cvalue, exdays) {
                    var d = new Date();
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    var expires = "expires=" + d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }


                function nsnc() {

                    x11 = jQuery("#x11").val() * 1;
                    x12 = jQuery("#x12").val() * 1;
                    x31 = jQuery("#x31").val() * 1;
                    x32 = jQuery("#x32").val() * 1;
                    x22 = jQuery("#x22").val() * 1;



                    var x21 = (x31 * (x22 - x12) + x11 * (x32 - x22)) / (x32 - x12);

                    jQuery("#x21").val(x21.toFixed(4));
                }


                function nstc() {

                    x11 = jQuery("#x11").val() * 1;
                    x12 = jQuery("#x12").val() * 1;
                    x31 = jQuery("#x31").val() * 1;
                    x32 = jQuery("#x32").val() * 1;
                    x21 = jQuery("#x21").val() * 1;



                    var x22 = ((x21 - x11) * x32 + (x31 - x21) * x12) / (-x11 + x31);


                    jQuery("#x22").val(x22.toFixed(4));
                }

                function reset(d) {
                    jQuery("#x21").val('');
                    jQuery("#x22").val('');

                    setCookie(d, jQuery("#" + d).val());

                }
            </script>

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
            $(window).scrollTop(0);
            rs = JSON.parse(msg);
            newTabResult = $("#newTabResult");
            if (newTabResult[0].checked == false) {
                $('#result').html('<div class="alert alert-success" role="alert">Báo cáo của bạn đã sẵn sàng để tải xuống. <a href="' + rs.filePath + '">Tải xuống</a></div>')
                $('#luot_tinh').html(rs.luot_tinh)
            } else {
                window.open('/tinh-toan/result?filePath=' + rs.filePath, '_blank');
            }
        });
    }

</script>