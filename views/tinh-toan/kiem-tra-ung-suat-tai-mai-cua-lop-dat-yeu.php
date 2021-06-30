<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'KIỂM TRA ỨNG SUẤT TẠI MÁI CỦA LỚP ĐẤT YẾU NẰM DƯỚI ĐÁY MÓNG';
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

        <p><i>Phương pháp tính toán dựa theo TCVN 9362-2012 Thiết kế nền nhà và công trình, mục 4.6.9-4.6.11 và 4.6.21.</i></p>
        <p>Để hạn chế biến dạng của nền, móng và kết cấu bên trên trong công tác thiết kế nền móng khi trong tầng chịu nén của nền ở độ sâu z cách đáy móng xuất hiện lớp đất yếu có độ bền nhỏ hơn độ bền của các lớp bên trên thì việc kiểm tra ứng suất tại mái của lớp đất yếu nằm dưới đáy móng là thực sự cần thiết.</p>
        
        <h3 class="text-center" style="font-size: 20px;">THÔNG SỐ ĐẦU VÀO</h3>
        <table class="input-table">
            <tr>
                <td><strong>Tải trọng tác dụng </strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Tải trọng tác dụng lên móng </td>
                <td style="width: 70px"> N <sub> II </sub> = </td>
                <td style="width: 200px">
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="2000" step="1" name="varNII" id="varNII"> 
                </td>
                <td> kN </td>
            </tr>
            <tr>
                <td><strong>Đặc trưng đất nền </strong></td>
            </tr>
            <tr>
                <td>Góc ma sát trong của lớp đất yếu </td>
                <td> 	&phi;<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="20" step="0.1" name="varPhiII" id="varPhiII"> 
                </td>
                <td> o</td>
            </tr>
            <tr>
                <td>Lực dính của đất yếu </td>
                <td> c<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="18" step="1" name="varCII" id="varCII"> 
                </td>
                <td> kN/m<sup>2</sup> </td>
            </tr>
            <tr>
                <td>Khối lượng thể tích của đất trên đáy móng </td>
                <td> &gamma;'<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="18.5" step="0.1" name="varGammaIIPhay" id="varGammaIIPhay"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Khối lượng thể tích của đất dưới đáy móng nhưng trên lớp đất yếu</td>
                <td> &gamma;<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="19.0" step="0.1" name="varGammaII2Phay" id="varGammaII2Phay"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Khối lượng thể tích của đất yếu</td>
                <td> &gamma;<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="17.0" step="0.1" name="varGammaII" id="varGammaII"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>

            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng hình học móng</strong></td>
            </tr>
            <tr>
                <td>Chiều rộng đáy móng </td>
                <td> b = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="2.5" step="0.1" name="varB" id="varB"> 
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều dài đáy móng (l ≥ b)</td>
                <td> l = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="3" step="0.1" name="varL" id="varL"> 
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Chiều sâu đặt móng </td>
                <td> h = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="1.5" step="0.01" name="varH" id="varH"> 
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td>Khoảng cách từ đáy móng đến mái của lớp đất yếu </td>
                <td> z = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="1.0" step="0.01" name="varZ" id="varZ"> 
                </td>
                <td> m </td>
            </tr>
            <tr>
                <td><i> Tầng hầm (có/không)</i> </td>
                <td>  </td>
                <td>
                    <select id="check-tang-ham" class="form-control" name="check-tang-ham">
                        <option value="yes">&#10003;</option>
                        <option value="no">&#10005;</option>
                    </select>
                </td>
            </tr>
            <tr class="check-tang-ham-item">
                <td style="padding-left: 50px;">Chiều dày lớp đất ở phía trên đáy móng</td>
                <td> h<sub>1</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="0.5" step="0.01" name="varH1" id="varH1"> 
                </td>
                <td> - </td>
            </tr>
            <tr class="check-tang-ham-item">
                <td style="padding-left: 50px;">Chiều dày kết cấu sàn hầm ở phía trên đáy móng</td>
                <td> h<sub>2</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="0.3" step="0.01" name="varH2" id="varH2"> 
                </td>
                <td> - </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><strong>Các hệ số điều kiện làm việc</strong></td>
            </tr>
            <tr>
                <td>Hệ số điều kiện làm việc của nền đất </td>
                <td> m<sub>1</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="1.2" step="0.01" name="varM1" id="varM1"> 
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td>Hệ số điều kiện làm việc của công trình tương tác với nền </td>
                <td> m<sub>2</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="1" step="0.01" name="varM2" id="varM2"> 
                </td>
                <td> - </td>
            </tr>
            <tr>
                <td>Hệ số tin cậy </td>
                <td> k<sub>tc</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="1" step="0.01" name="varKtc" id="varKtc"> 
                </td>
                <td> - </td>
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