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
                <td><strong>Đặc trưng đất nền (Tính theo TTGH II) </strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Góc ma sát trong </td>
                <td style="width: 70px"> &#966; <sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="20.0" step="0.01" name="varPhiII" id="varPhiII"> 
                </td>
                <td> 0 </td>
            </tr>
            <tr>
                <td>Lực dính đơn vị của đất nằm trực tiếp dưới đáy móng </td>
                <td> c<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="18" step="18.0" name="varCII" id="varCII"> 
                </td>
                <td> kN/m<sup>2</sup> </td>
            </tr>
            <tr>
                <td>Khối lượng thể tích của đất trên đáy móng </td>
                <td> &gamma;'<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="18.5" step="0.01" name="varGamma1" id="varGamma1"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td>Khối lượng thể tích của đất dưới đáy móng </td>
                <td> &gamma;<sub> II </sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="19.0" step="0.01" name="varGamma2" id="varGamma2"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>
            <tr>
                <td><i> Có tính đến hiện tượng đẩy nổi của đất (có/không)</i> </td>
                <td>  </td>
                <td>
                    <select id="check-day-noi" class="form-control" name="check-day-noi">
                        <option value="yes">&#10003;</option>
                        <option value="no">&#10005;</option>
                    </select>
                </td>
            </tr>

            <tr class="check-day-noi-item">
                <td style="padding-left: 50px;">Khối lượng thể tích hạt đất </td>
                <td>&gamma;<sub>s</sub> = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="27" step="0.01" name="varGammaS" id="varGammaS"> 
                </td>
                <td> kN/m<sup>3</sup> </td>
            </tr>
            <tr class="check-day-noi-item">
                <td style="padding-left: 50px;">Hệ số rỗng</td>
                <td> e = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="0.7" step="0.01" name="varE" id="varE"> 
                </td>
                <td> - </td>
            </tr>
            <!-- ============ -->
            <tr>
                <td><strong>Đặc trưng hình học móng</strong></td>
            </tr>
            <tr>
                <td>Chiều rộng đáy móng </td>
                <td> b = </td>
                <td>
                    <input required class="form-control" pattern="[0-9]*.[0-9]+" value="2.5" step="0.01" name="varB" id="varB"> 
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
            <img src="/images/04/ap-luc-nen.jpg" alt="Hình 1. Các trường hợp móng" width="500px">
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