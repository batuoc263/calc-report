<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'XÁC ĐỊNH TẢI TRỌNG TÁC DỤNG LÊN ĐẦU CỌC';
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
        <table class="input-table">
            <tr>
                <td><strong>Tải trọng tác dụng tại cao trình đáy đài </strong></td>
            </tr>
            <tr>
                <td style="width: 420px">Tải trọng thẳng đứng  </td>
                <td style="width: 50px"> N   = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" lang="en" value="5000" step="0.1" name="varN" id="varN"> kN
                </td>
            </tr>
            <tr>
                <td>Mômen uốn, xoay quanh trục  x tại cao trình đáy đài </td>
                <td> M<sub>x </sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="120" step="0.1" name="varMx" id="varMx"> kN.m
                </td>
            </tr>
            <tr>
                <td>Mômen uốn, xoay quanh trục y tại cao trình đáy đài </td>
                <td> M<sub>y </sub> = </td>
                <td>
                    <input required pattern="[0-9]*.[0-9]+" value="150" step="0.1" name="varMy" id="varMy"> kN.m
                </td>
            </tr>
            
        </table>
        <div class="text-center" style="margin-top: 10px">
            <img src="/images/06/quy-uoc-huong.jpg" alt="Hình 1. Quy ước hướng" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Quy ước hướng và vị trí đặt lực của tải trọng tác dụng</i></p>


        <div class="row">
            <div class="col-md-6">
                <table id="input-table">

                    <thead>
                        <tr>
                            <th>Cọc i</th>
                            <th>x<sub>i</sub> (m)</th>
                            <th>y<sub>i</sub> (m)</th>
                        </tr>
                    </thead>
                        <tr><td>1</td><td > <input  id="x1" name="x1" required pattern="[0-9]*.[0-9]+" value="0.00" step="0.01"/> </td><td><input type="text" id="y1" name="y1" required pattern="[0-9]*.[0-9]+" value="0.00" step="0.01"/></td></tr> 
                        <tr><td>2</td><td > <input  id="x2" name="x1" required pattern="[0-9]*.[0-9]+" value="3.00" step="0.01"/> </td><td><input type="text" id="y2" name="y1" required pattern="[0-9]*.[0-9]+" value="0.00" step="0.01"/></td></tr> 
                        <tr><td>3</td><td > <input  id="x3" name="x1" required pattern="[0-9]*.[0-9]+" value="3.00" step="0.01"/> </td><td><input type="text" id="y3" name="y1" required pattern="[0-9]*.[0-9]+" value="1.80" step="0.01"/></td></tr> 
                        <tr><td>4</td><td > <input  id="x4" name="x1" required pattern="[0-9]*.[0-9]+" value="0.00" step="0.01"/> </td><td><input type="text" id="y4" name="y1" required pattern="[0-9]*.[0-9]+" value="1.80" step="0.01"/></td></tr> 
                        <tr><td>5</td><td > <input  id="x5" name="x1" required pattern="[0-9]*.[0-9]+" value="1.50" step="0.01"/> </td><td><input type="text" id="y5" name="y1" required pattern="[0-9]*.[0-9]+" value="0.00" step="0.01"/></td></tr> 
                        <tr><td>6</td><td > <input  id="x6" name="x1" required pattern="[0-9]*.[0-9]+" value="1.50" step="0.01"/> </td><td><input type="text" id="y6" name="y1" required pattern="[0-9]*.[0-9]+" value="1.80" step="0.01"/></td></tr> 
                        <tr><td>7</td><td > <input  id="x7" name="x1" required pattern="[0-9]*.[0-9]+" value="0.75" step="0.01"/> </td><td><input type="text" id="y7" name="y1" required pattern="[0-9]*.[0-9]+" value="0.90" step="0.01"/></td></tr> 
                        <tr><td>8</td><td > <input  id="x8" name="x1" required pattern="[0-9]*.[0-9]+" value="2.25" step="0.01"/> </td><td><input type="text" id="y8" name="y1" required pattern="[0-9]*.[0-9]+" value="0.90" step="0.01"/></td></tr> 
                    <tbody id="tbl_posts_body">

                    </tbody>
                </table>

                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button id="add-coc" type="button" class="btn btn-primary">Thêm cọc</button>
                    </div>
                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                        <button id="del-coc" type="button" class="btn btn-danger">Xóa cọc</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

                <!-- <canvas id="myCanvas" width="400px" height="300px" style="border:1px solid #000000;"></canvas> -->
                <Canvas id="myCanvas" width="400px" height="300px" style="border:1px solid #000000;">
                    <Canvas.LayoutTransform>
                        <ScaleTransform ScaleX="1" ScaleY="-1" CenterX=".5" CenterY=".5" />
                    </Canvas.LayoutTransform>
                </Canvas>
            </div>
        </div>



        <div class="checkbox">
                <label>
                    <input type="checkbox" id="newTabResult" value="">
                    Mở kết quả trên tab mới
                </label>
            </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <button id="btn-tinhtoan" class="btn btn-primary">Tính toán</button>
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
        let lineNo = 8;

        $(document).ready(function () {
            $("#add-coc").click(function () {
                markup = '<tr><td>'+lineNo+'</td><td > <input type="text" id="x'+lineNo+'" name="x'+lineNo+'" /> </td><td><input type="text" id="y'+lineNo+'" name="y'+lineNo+'" /></td></tr> ';
                tableBody = $("#input-table tbody");
                tableBody.append(markup);
                lineNo++;
            });

            $('#del-coc').on("click", function(){
                $('#input-table tr:last').remove();
                lineNo--;
            })

            var c = document.getElementById("myCanvas");
            var transX = c.width ,
            transY = c.height;

            var ctx = c.getContext("2d");
            ctx.transform(1, 0, 0, -1, 0, c.height)
            
            for(var i = 1; i <= lineNo; i++) {
                x = $("#x"+i+"").val();
                y = $("#y"+i+"").val();
                ctx.fillRect(x*100 + 30, y*100 + 30,5,5);
                ctx.fillText(i, x*100 +35, y*100  +35 );
                ctx.save();
            }
            ctx.restore();


            $("#btn-tinhtoan").click(function() {
                tinhtoan(lineNo);
            })
        }); 

   
    function tinhtoan(lineNo) {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        varN = $('#varN').val()
        varMx = $('#varMx').val()
        varMy = $('#varMy').val()
        lineNo = lineNo
        list = [];
        for (var i = 1; i<= lineNo; i ++) {
            list.push([ $("#x"+i).val(), $("#y"+i).val()]);
        }

        data= {
                _token: CSRF_TOKEN,
                varN: varN,
                varMx: varMx,
                varMy: varMy,
                lineNo: lineNo,
                list: list
            };

        console.log(data);
        $.ajax({
            method: "POST",
            url: "/tinh-toan/xac-dinh-tai-trong-tac-dung-len-dau-coc",
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