<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
?>

<div class="col-md-9">   
<table class="input-table">
            <tr>
                <td style="width: 420px">Cấu kiện </td>
                <td style="width: 70px"> </td>
                <td style="width: 200px">
                    <select id="loai" class="form-control" name="loai">
                        <option value="san">Sàn</option>
                        <option value="dam">Dầm</option>
                        <option value="cot">Cột</option>
                    </select>
                </td>
                <td></td>
            </tr>
           
            
        </table>
</div>

<?php
$this->title = 'TÍNH TOÁN CỐP PHA SÀN';
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
        
        <p><i>Phương pháp tính toán dựa theo tiêu chuẩn TCVN 4453 - 1995: Kết cấu bê tông và bê tông cốt thép toàn khối - Quy phạm thi công và nghiệm thu, TCVN 5575-2012: Kết cấu thép - Tiêu chuẩn thiết kế.</i></p>
        
        
        <h3 class="text-center" style="font-size: 20px;">THÔNG SỐ ĐẦU VÀO</h3>
        <table class="input-table">
            <tr>
                <td><strong>Đặc trưng vật liệu</strong></td>
            </tr>
            <tr>
                <td><i>Sàn bê tông cốt thép</i></td>
            </tr>
            <tr>
                <td style="width: 30%">Chiều dày </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> h<sub>s</sub> = </td>
                <td style="width: 10%">
                    <input class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="0.25" step="0.01" name="varHs" id="varHs">
                </td>
                <td style="width: 10%"> m </td>
            </tr>
            <tr>
                <td>Trọng lượng riêng</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > &gamma;<sub>b</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="25" step="0.1" name="varGammab" id="varGammab"> 
                </td>
                <td >  kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td><i>Ván ép</i></td>
            </tr>
            <tr>
                <td>Chiều dày</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > h<sub>1</sub> = </td>
                <td >
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="0.018" step="0.001" name="varH1" id="varH1">
                </td>
                <td > m </td>
            </tr>
            <tr>
                <td>Trọng lượng riêng </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > &gamma;'<sub>1</sub> = </td>
                <td >
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="7.0" step="0.1" name="varGamma1" id="varGamma1"> 
                </td>
                <td >kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Bề rộng dải tính toán</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td >b =</td>
                <td >
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="19.0" step="0.1" name="varB" id="varB">
                </td>
                <td >m</td>
            </tr>
            <tr>
                <td>Mô men quán tính</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td >I<sub>1</sub> =</td>
                <td >
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="48.6" step="0.1" name="varI1" id="varI1">
                </td>
                <td >  cm<sup>4</sup> </td>
            </tr>
            <tr>
                <td>Mô men kháng uốn</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td >W<sub>1 </sub> =</td>
                <td >
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="54" step="0.1" name="varW1" id="varW1"> 
                </td>
                <td > cm<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Cường độ vật liệu</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td >[&sigma;<sub>1 </sub>] =</td>
                <td >
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="18000" step="1" name="varSigma1" id="varSigma1"> 
                </td>
                <td > kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Mô đun đàn hồi</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td >[E<sub>1 </sub>] = </td>
                <td >
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="5000000" step="1000" name="varE1" id="varE1">
                </td>
                <td > kN/m<sup>2</sup> </td>
            </tr>

            <!-- ============ -->

            <tr>
                <td><i>Đà</i></td>
                <td colspan="3"  style="text-align: center;"> Đà phụ</td>

                <td colspan="4" style="text-align: center;"> Đà chính </td>
            </tr>

            <tr>
                <td>Loại Đà</td>
                <td colspan="3" style="text-align: center;">
                    <select id="loai" class="form-control" name="loai">
                        <option value="san">Box steel 50x50x1.5</option>
                    </select>
                </td>
                <td colspan="4" style="text-align: center;">
                    <select id="loai" class="form-control" name="loai">
                        <option value="san">Box steel 50x50x1.5</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Trọng lượng riêng </td>
                <td> &gamma;<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="varGamma2" id="varGamma2"> </td>
                <td> kN/m <sup>3</sup> </td>
                <td> </td>
                <td> &gamma;<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="varGamma3" id="varGamma3"> </td>
                <td>  kN/m <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Mô men quán tính </td>
                <td> I<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="11.42" step="0.1" name="varI2" id="varI2"> </td>
                <td> cm <sup>4</sup> </td>
                <td> </td>
                <td> I<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="112.11" step="0.1" name="varI3" id="varI3"> </td>
                <td>  cm <sup>4</sup> </td>
            </tr>
            <tr>
                <td>Mô men kháng uốn</td>
                <td> W<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="4.75" step="0.1" name="varW2" id="varW2"> </td>
                <td> cm <sup>3</sup> </td>
                <td> </td>
                <td> W<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="24.91" step="0.1" name="varW3" id="varW3"> </td>
                <td>  cm <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Cường độ chịu uốn </td>
                <td> [&sigma;<sub>2 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="varSigma2" id="varSigma2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> [&sigma;<sub>3 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="varSigma3" id="varSigma3"> </td>
                <td>  kN/m <sup>2</sup> </td>
            </tr>
            <tr>
                <td>Mô đun đàn hồi </td>
                <td> E<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="varE2" id="varE2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> E<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="varE3" id="varE3"> </td>
                <td>  kN/m <sup>2</sup> </td>
            </tr>


            <tr>
                <td><i>Cây chống</i></td>
            </tr>
            <tr>
                <td colspan="3">Diện tích truyền tải lên 1 cây chống</td>
                <td > </td>
                <td > </td>
                <td > S = </td>
                <td >
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="0.4" step="0.1" name="varS" id="varS">
                </td>
                <td > m<sup>2</sup> </td>
            </tr>
            <tr>
                <td colspan="2">Sức chịu nén (1 chống)</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > {P] = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="60" step="0.1" name="varP" id="varP">
                </td>
                <td > m<sup>2</sup> </td>
            </tr>
            <tr>
                <td colspan="2">Khoảng cách đà phụ</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > L<sub>1</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.25" step="0.1" name="varL1" id="varL1">
                </td>
                <td > m </td>
            </tr>
            <tr>
                <td colspan="2">Khoảng cách đà chính</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > L<sub>2</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.8" step="0.1" name="varL2" id="varL2">
                </td>
                <td > m<sup>2</sup> </td>
            </tr>
            <tr>
                <td colspan="2">Khoảng cách cây chống</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > L<sub>3</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.4" step="0.1" name="varL3" id="varL3">
                </td>
                <td > m<sup>2</sup> </td>
            </tr>


            <tr>
                <td><strong>Tải trọng tác dụng</strong></td>
                <td colspan="3" > hệ số vượt tải </td>
                <td > </td>
                <td style="text-align: center;"> q <sup> tc </sup> </td>
                <td style="text-align: center;"> q <sup> tt </sup> </td>
                <td > - </td>
            </tr>

            
            <tr>
                <td><strong>Trọng lượng sàn bê tông</strong></td>
                <td > n<sub>1</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.2" step="0.1" name="varN1" id="varN1"></td>
                <td > </td>
                <td > q <sub> 1 </sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="6.25" step="0.1" name="varQtc1" id="varQtc1"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="7.5" step="0.1" name="varQtt1" id="varQtt1"></td>
                <td > <td>  kN/m <sup>2</sup> </td> </td>
            </tr>
            <tr>
                <td><strong>Trọng lượng cốp pha</strong></td>
                <td > n<sub>2</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.1" step="0.1" name="varN2" id="varN2"></td>
                <td > </td>
                <td > q <sub>2</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="60.1" step="0.1" name="varQtc2" id="varQtc2"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.11" step="0.1" name="varQtt2" id="varQtt2"></td>
                <td > <td>  kN/m <sup>2</sup> </td> </td>
            </tr>
            <tr>
                <td><strong>Tải người và thiết bị</strong></td>
                <td > n<sub>3</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="varN3" id="varN3"></td>
                <td > </td>
                <td > q <sub>3</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.5" step="0.1" name="varQtc3" id="varQtc3"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="3.25" step="0.1" name="varQtt3" id="varQtt3"></td>
                <td > <td>  kN/m <sup>2</sup> </td> </td>
            </tr>
            <tr>
                <td><strong>Tải trọng do dầm rung</strong></td>
                <td > n<sub>4</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="varN4" id="varN4"></td>
                <td > </td>
                <td > q <sub>4</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.0" step="0.1" name="varQtc4" id="varQtc4"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.6" step="0.1" name="varQtt4" id="varQtt4"></td>
                <td > <td>  kN/m <sup>2</sup> </td> </td>
            </tr>
            <tr>
                <td><strong>Tải trọng động do đổ bê tông</strong></td>
                <td > n<sub>5</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="varN5" id="varN5"></td>
                <td > </td>
                <td > q <sub>5</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.5" step="0.1" name="varQtc5" id="varQtc5"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.65" step="0.1" name="varQtt5" id="varQtt5"></td>
                <td > <td>  kN/m <sup>2</sup> </td> </td>
            </tr>
            <tr>
                <td><strong>Tổng</strong></td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > &epsilon;q = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="11.35" step="0.1" name="varSumQtc" id="varSumQtc"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="14.11" step="0.1" name="varSumQtt" id="varSumQtt"></td>
                <td > <td>  kN/m <sup>2</sup> </td> </td>
            </tr>
            
        </table>
        <div class="text-center" style="margin-top: 10px">
            <img src="/images/21/hinh1.jpg" alt="Hình 1. Các trường hợp móng" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Các trường hợp móng</i></p>

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
    $(document).ready(function() {
        
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

        varNII = $('#varNII').val()
        varPhiII = $('#varPhiII').val()
        varCII = $('#varCII').val()
        varGammaII = $('#varGammaII').val()
        varGammaIIPhay = $('#varGammaIIPhay').val()
        varGammaII2Phay = $('#varGammaII2Phay').val()
        varH = $('#varH').val()
        varB = $('#varB').val()
        varL = $('#varL').val()
        varZ = $('#varZ').val()
        varH1 = $('#varH1').val()
        varH2 = $('#varH2').val()
        varM1 = $('#varM1').val()
        varM2 = $('#varM2').val()
        varKtc = $('#varKtc').val()
        check_tang_ham = $("#check-tang-ham").val()

        data= {
                _token: CSRF_TOKEN,
                varNII : varNII,
                varPhiII: varPhiII,
                varCII: varCII,
                varGammaII: varGammaII,
                varGammaIIPhay: varGammaIIPhay,
                varGammaII2Phay: varGammaII2Phay,
                varH: varH,
                varB: varB,
                varL: varL,
                varZ: varZ,
                varH1: varH1,
                varH2: varH2,
                varM1: varM1,
                varM2: varM2,
                varKtc: varKtc,
                check_tang_ham: check_tang_ham
            };
        console.log(data);
        $.ajax({
            method: "POST",
            url: "/tinh-toan/kiem-tra-ung-suat-tai-mai-cua-lop-dat-yeu",
            data: data
        }).done(function(msg) {
            console.log(msg)
            $(window).scrollTop(0); rs = JSON.parse(msg); 
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