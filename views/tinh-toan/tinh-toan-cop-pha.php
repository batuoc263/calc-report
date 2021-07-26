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


                <td style="width: 30%"> Cấu kiện </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 20%">
                <select id="loai" class="form-control" name="loai">
                        <option value="san">Sàn</option>
                        <option value="dam">Dầm</option>
                        <option value="cot">Cột</option>
                    </select>
                </td>
                <td style="width: 0%"> </td>
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
        <h1 id = "title" class="text-uppercase" style="font-size: 25px;"></h1>
    </div>
        <div id="result">

        </div>
        
        <p><i>Phương pháp tính toán dựa theo tiêu chuẩn TCVN 4453 - 1995: Kết cấu bê tông và bê tông cốt thép toàn khối - Quy phạm thi công và nghiệm thu, TCVN 5575-2012: Kết cấu thép - Tiêu chuẩn thiết kế.</i></p>
        
        
        <h3 class="text-center" style="font-size: 20px;">THÔNG SỐ ĐẦU VÀO</h3>
        <table class="input-table-san">
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
                    <input class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="0.25" step="0.01" name="SvarHs" id="SvarHs">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="25" step="0.1" name="SvarGammab" id="SvarGammab"> 
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
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="0.018" step="0.001" name="SvarH1" id="SvarH1">
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="7.0" step="0.1" name="SvarGamma1" id="SvarGamma1"> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="1.0" step="0.1" name="SvarB" id="SvarB" disabled>
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="48.6" step="0.1" name="SvarI1" id="SvarI1" disabled>
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="54" step="0.1" name="SvarW1" id="SvarW1" disabled> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="18000" step="1" name="SvarSigma1" id="SvarSigma1"> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="5000000" step="1000" name="SvarE1" id="SvarE1">
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
                    <select id="S-loai-1" class="form-control" name="loai">
                        <?php
                            foreach ($arrI as $key => $value) {
                                echo "<option value='$key'>$key</option>";
                            }
                        ?>
                    </select>
                </td>
                <td> </td>
                <td colspan="3" style="text-align: center;">
                    <select id="S-loai-2" class="form-control" name="loai">
                        <?php
                            foreach ($arrI as $key => $value) {
                                echo "<option value='$key'>$key</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Trọng lượng riêng </td>
                <td> &gamma;<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="SvarGamma2" id="SvarGamma2"> </td>
                <td> kN/m <sup>3</sup> </td>
                <td> </td>
                <td> &gamma;<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="SvarGamma3" id="SvarGamma3"> </td>
                <td>  kN/m <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Mô men quán tính </td>
                <td> I<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="11.42" step="0.1" name="SvarI2" id="SvarI2"> </td>
                <td> cm <sup>4</sup> </td>
                <td> </td>
                <td> I<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="56.06" step="0.1" name="SvarI3" id="SvarI3"> </td>
                <td>  cm <sup>4</sup> </td>
            </tr>
            <tr>
                <td>Mô men kháng uốn</td>
                <td> W<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="4.75" step="0.1" name="SvarW2" id="SvarW2"> </td>
                <td> cm <sup>3</sup> </td>
                <td> </td>
                <td> W<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="12.46" step="0.1" name="SvarW3" id="SvarW3"> </td>
                <td>  cm <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Cường độ chịu uốn </td>
                <td> [&sigma;<sub>2 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000" step="0.1" name="SvarSigma2" id="SvarSigma2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> [&sigma;<sub>3 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000" step="0.1" name="SvarSigma3" id="SvarSigma3"> </td>
                <td>  kN/m <sup>2</sup> </td>
            </tr>
            <tr>
                <td>Mô đun đàn hồi </td>
                <td> E<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000000" step="0.1" name="SvarE2" id="SvarE2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> E<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000000" step="0.1" name="SvarE3" id="SvarE3"> </td>
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
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="0.9" step="0.1" name="SvarS" id="SvarS">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="25" step="0.1" name="SvarP" id="SvarP">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.3" step="0.1" name="SvarL1" id="SvarL1">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.8" step="0.1" name="SvarL2" id="SvarL2">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.25" step="0.1" name="SvarL3" id="SvarL3">
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
                <td>Trọng lượng sàn bê tông</td>
                <td > n<sub>1</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.2" step="0.1" name="SvarN1" id="SvarN1"></td>
                <td > </td>
                <td > q <sub> 1 </sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="6.25" step="0.1" name="SvarQtc1" id="SvarQtc1"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="7.5" step="0.1" name="SvarQtt1" id="SvarQtt1"></td>
                <td > kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Trọng lượng cốp pha</td>
                <td > n<sub>2</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.1" step="0.1" name="SvarN2" id="SvarN2"></td>
                <td > </td>
                <td > q <sub>2</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.1" step="0.1" name="SvarQtc2" id="SvarQtc2"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.11" step="0.1" name="SvarQtt2" id="SvarQtt2"></td>
                <td >   kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tải người và thiết bị</td>
                <td > n<sub>3</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="SvarN3" id="SvarN3"></td>
                <td > </td>
                <td > q <sub>3</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.5" step="0.1" name="SvarQtc3" id="SvarQtc3"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="3.25" step="0.1" name="SvarQtt3" id="SvarQtt3"></td>
                <td >   kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tải trọng do dầm rung</td>
                <td > n<sub>4</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="SvarN4" id="SvarN4"></td>
                <td > </td>
                <td > q <sub>4</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.0" step="0.1" name="SvarQtc4" id="SvarQtc4"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.6" step="0.1" name="SvarQtt4" id="SvarQtt4"></td>
                <td >   kN/m <sup>2</sup> </td>
            </tr>
            <tr>
                <td>Tải trọng động do đổ bê tông</td>
                <td > n<sub>5</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="SvarN5" id="SvarN5"></td>
                <td > </td>
                <td > q <sub>5</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.5" step="0.1" name="SvarQtc5" id="SvarQtc5"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.65" step="0.1" name="SvarQtt5" id="SvarQtt5"></td>
                <td > kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tổng</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > &epsilon;q = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="11.35" step="0.1" name="SvarSumQtc" id="SvarSumQtc"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="14.11" step="0.1" name="SvarSumQtt" id="SvarSumQtt"></td>
                <td >  kN/m <sup>2</sup>  </td>
            </tr>
            
        </table>




        <table class="input-table-dam">
            <tr>
                <td><strong>Đặc trưng vật liệu</strong></td>
            </tr>
            <tr>
                <td><i>Dầm bê tông cốt thép</i></td>
            </tr>
            <tr>
                <td style="width: 30%">Chiều cao </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> h<sub>d</sub> = </td>
                <td style="width: 10%">
                    <input class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="1.2" step="0.01" name="DvarHd" id="DvarHd">
                </td>
                <td style="width: 10%"> m </td>
            </tr>
            <tr>
                <td style="width: 30%">Chiều rộng </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> b<sub>d</sub> = </td>
                <td style="width: 10%">
                    <input class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="1.0" step="0.01" name="DvarBd" id="DvarBd">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="25" step="25" name="DvarGammab" id="DvarGammab"> 
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
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="0.018" step="0.018" name="DvarH1" id="DvarH1">
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="0.7" step="7.0" name="DvarGamma1" id="DvarGamma1"> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="1.0" step="1.0" name="DvarB" id="DvarB" disabled>
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="48.6" step="0.1" name="DvarI1" id="DvarI1" disabled>
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="54" step="0.1" name="DvarW1" id="DvarW1" disabled> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="18000" step="1" name="DvarSigma1" id="DvarSigma1"> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="5000000" step="1000" name="DvarE1" id="DvarE1">
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
                    <select id="D-loai-1" class="form-control" name="loai">
                     <?php
                            foreach ($arrI as $key => $value) {
                                echo "<option value='$key'>$key</option>";
                            }
                        ?>
                    </select>
                </td>
                <td> </td>
                <td colspan="3" style="text-align: center;">
                    <select id="D-loai-2" class="form-control" name="loai">
                        <?php
                            foreach ($arrI as $key => $value) {
                                echo "<option value='$key'>$key</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Trọng lượng riêng </td>
                <td> &gamma;<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="DvarGamma2" id="DvarGamma2"> </td>
                <td> kN/m <sup>3</sup> </td>
                <td> </td>
                <td> &gamma;<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="DvarGamma3" id="DvarGamma3"> </td>
                <td>  kN/m <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Mô men quán tính </td>
                <td> I<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="11.42" step="0.1" name="DvarI2" id="DvarI2"> </td>
                <td> cm <sup>4</sup> </td>
                <td> </td>
                <td> I<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="112.11" step="0.1" name="DvarI3" id="DvarI3"> </td>
                <td>  cm <sup>4</sup> </td>
            </tr>
            <tr>
                <td>Mô men kháng uốn</td>
                <td> W<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="4.75" step="0.1" name="DvarW2" id="DvarW2"> </td>
                <td> cm <sup>3</sup> </td>
                <td> </td>
                <td> W<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="24.91" step="0.1" name="DvarW3" id="DvarW3"> </td>
                <td>  cm <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Cường độ chịu uốn </td>
                <td> [&sigma;<sub>2 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="2100000" step="0.1" name="DvarSigma2" id="DvarSigma2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> [&sigma;<sub>3 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="2100000" step="0.1" name="DvarSigma3" id="DvarSigma3"> </td>
                <td>  kN/m <sup>2</sup> </td>
            </tr>
            <tr>
                <td>Mô đun đàn hồi </td>
                <td> E<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000000" step="0.1" name="DvarE2" id="DvarE2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> E<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000000" step="0.1" name="DvarE3" id="DvarE3"> </td>
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
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="0.4" step="0.1" name="DvarS" id="DvarS">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="60" step="0.1" name="DvarP" id="DvarP">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.25" step="0.1" name="DvarL1" id="DvarL1">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.8" step="0.1" name="DvarL2" id="DvarL2">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.25" step="0.1" name="DvarL3" id="DvarL3">
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
                <td>Trọng lượng sàn bê tông</td>
                <td > n<sub>1</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.2" step="0.1" name="DvarN1" id="DvarN1"></td>
                <td > </td>
                <td > q <sub> 1 </sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="30.0" step="0.1" name="DvarQtc1" id="DvarQtc1"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="36.0" step="0.1" name="DvarQtt1" id="DvarQtt1"></td>
                <td > kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Trọng lượng cốp pha</td>
                <td > n<sub>2</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.1" step="0.1" name="DvarN2" id="DvarN2"></td>
                <td > </td>
                <td > q <sub>2</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.1" step="0.1" name="DvarQtc2" id="DvarQtc2"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.11" step="0.1" name="DvarQtt2" id="DvarQtt2"></td>
                <td >   kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tải người và thiết bị</td>
                <td > n<sub>3</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="DvarN3" id="DvarN3"></td>
                <td > </td>
                <td > q <sub>3</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.5" step="0.1" name="DvarQtc3" id="DvarQtc3"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="3.25" step="0.1" name="DvarQtt3" id="DvarQtt3"></td>
                <td >   kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tải trọng do dầm rung</td>
                <td > n<sub>4</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="DvarN4" id="DvarN4"></td>
                <td > </td>
                <td > q <sub>4</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.0" step="0.1" name="DvarQtc4" id="DvarQtc4"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="2.6" step="0.1" name="DvarQtt4" id="DvarQtt4"></td>
                <td >   kN/m <sup>2</sup> </td>
            </tr>
            <tr>
                <td>Tải trọng động do đổ bê tông</td>
                <td > n<sub>5</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="DvarN5" id="DvarN5"></td>
                <td > </td>
                <td > q <sub>5</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.5" step="0.1" name="DvarQtc5" id="DvarQtc5"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.65" step="0.1" name="DvarQtt5" id="DvarQtt5"></td>
                <td > kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tổng</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > &epsilon;q = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="35.1" step="0.1" name="DvarSumQtc" id="DvarSumQtc"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="42.61" step="0.1" name="DvarSumQtt" id="DvarSumQtt"></td>
                <td >  kN/m <sup>2</sup>  </td>
            </tr>
            
        </table>



        <table class="input-table-cot">
            <tr>
                <td><strong>Đặc trưng vật liệu</strong></td>
            </tr>
            <tr>
                <td><i>Cột bê tông cốt thép</i></td>
            </tr>
            <tr>
                <td style="width: 30%">Chiều cao đổ bê tông</td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> </td>
                <td style="width: 10%"> h<sub>c</sub> = </td>
                <td style="width: 10%">
                    <input class="form-control" pattern="[0-9]*.[0-9]+" lang="en" value="2.2" step="0.01" name="CvarHc" id="CvarHc">
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
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="25" step="0.1" name="CvarGammab" id="CvarGammab"> 
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
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="0.018" step="0.001" name="CvarH1" id="CvarH1">
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="7.0" step="0.1" name="CvarGamma1" id="CvarGamma1"> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="1.0" step="0.1" name="CvarB" id="CvarB" disabled>
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="48.6" step="0.1" name="CvarI1" id="CvarI1" disabled>
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="54" step="0.1" name="CvarW1" id="CvarW1" disabled> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="18000" step="1" name="CvarSigma1" id="CvarSigma1"> 
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
                    <input class="form-control"  pattern="[0-9]*.[0-9]+" value="5000000" step="1000" name="CvarE1" id="CvarE1">
                </td>
                <td > kN/m<sup>2</sup> </td>
            </tr>

            <!-- ============ -->

            <tr>
                <td><i>Gông</i></td>
                <td colspan="3"  style="text-align: center;"> Sườn phụ</td>

                <td colspan="4" style="text-align: center;"> Sườn chính </td>
            </tr>

            <tr>
                <td>Loại Đà</td>
                <td colspan="3" style="text-align: center;">
                    <select id="C-loai-1" class="form-control" name="loai">
                        <?php
                            foreach ($arrI as $key => $value) {
                                echo "<option value='$key'>$key</option>";
                            }
                        ?>
                    </select>
                </td>
                <td> </td>
                <td colspan="3" style="text-align: center;">
                    <select id="C-loai-2" class="form-control" name="loai">
                        <?php
                            foreach ($arrI as $key => $value) {
                                echo "<option value='$key'>$key</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Trọng lượng riêng </td>
                <td> &gamma;<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="CvarGamma2" id="CvarGamma2"> </td>
                <td> kN/m <sup>3</sup> </td>
                <td> </td>
                <td> &gamma;<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="78.5" step="0.1" name="CvarGamma3" id="CvarGamma3"> </td>
                <td>  kN/m <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Mô men quán tính </td>
                <td> I<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="11.42" step="0.1" name="CvarI2" id="CvarI2"> </td>
                <td> cm <sup>4</sup> </td>
                <td> </td>
                <td> I<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="112.11" step="0.1" name="CvarI3" id="CvarI3"> </td>
                <td>  cm <sup>4</sup> </td>
            </tr>
            <tr>
                <td>Mô men kháng uốn</td>
                <td> W<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="4.75" step="0.1" name="CvarW2" id="CvarW2"> </td>
                <td> cm <sup>3</sup> </td>
                <td> </td>
                <td> W<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="24.91" step="0.1" name="CvarW3" id="CvarW3"> </td>
                <td>  cm <sup>3</sup> </td>
            </tr>
            <tr>
                <td>Cường độ chịu uốn </td>
                <td> [&sigma;<sub>2 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="2100000" step="0.1" name="CvarSigma2" id="CvarSigma2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> [&sigma;<sub>3 </sub>] = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="2100000" step="0.1" name="CvarSigma3" id="CvarSigma3"> </td>
                <td>  kN/m <sup>2</sup> </td>
            </tr>
            <tr>
                <td>Mô đun đàn hồi </td>
                <td> E<sub>2</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000000" step="0.1" name="CvarE2" id="CvarE2"> </td>
                <td> kN/m <sup>2</sup> </td>
                <td> </td>
                <td> E<sub>3</sub> = </td>
                <td> <input class="form-control"  required  pattern="[0-9]*.[0-9]+" value="210000000" step="0.1" name="CvarE3" id="CvarE3"> </td>
                <td>  kN/m <sup>2</sup> </td>
            </tr>


            <tr>
                <td><i>Ty liên kết</i></td>
            </tr>
            <tr>
                <td colspan="3">Đường kính</td>
                <td > </td>
                <td > </td>
                <td > d = </td>
                <td >
                    <input  class="form-control"  pattern="[0-9]*.[0-9]+" value="16" step="0.1" name="CvarD" id="CvarD">
                </td>
                <td > mm </td>
            </tr>
            <tr>
                <td colspan="2">Cường độ tính toán</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > {&sigma;]<sub>4</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="210000" step="0.1" name="CvarSigma4" id="CvarSigma4">
                </td>
                <td > kN/m<sup>2</sup> </td>
            </tr>
            <tr>
                <td colspan="2">Mô đun đàn hồi</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > E<sub>2</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.25" step="0.1" name="CvarE22" id="CvarE22">
                </td>
                <td > kN/m<sup>2</sup> </td>
            </tr>
            <tr>
                <td colspan="2">Khoảng cách sườn phụ</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > L<sub>1</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.25" step="0.1" name="CvarL1" id="CvarL1">
                </td>
                <td > m </td>
            </tr>
            <tr>
                <td colspan="2">Khoảng cách sườn chính</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > L<sub>2</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="0.5" step="0.1" name="CvarL2" id="CvarL2">
                </td>
                <td > m</td>
            </tr>

            <tr>
                <td colspan="2">Khoảng cách giữa các ty liên kết</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > L<sub>3</sub> = </td>
                <td >
                    <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.0" step="0.1" name="CvarL3" id="CvarL3">
                </td>
                <td > m</td>
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
                <td>Trọng lượng ngang bê tông</td>
                <td > n<sub>1</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.2" step="0.1" name="CvarN1" id="CvarN1"></td>
                <td > </td>
                <td > q <sub> 1 </sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="27.50" step="0.1" name="CvarQtc1" id="CvarQtc1"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="33.00" step="0.1" name="CvarQtt1" id="CvarQtt1"></td>
                <td > kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tải trọng động do đổ bê tông</td>
                <td > n<sub>2</sub> = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="1.3" step="0.1" name="CvarN2" id="CvarN2"></td>
                <td > </td>
                <td > q <sub>2</sub>= </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="4.00" step="0.1" name="CvarQtc2" id="CvarQtc2"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="5.20" step="0.1" name="CvarQtt2" id="CvarQtt2"></td>
                <td >   kN/m <sup>2</sup>  </td>
            </tr>
            <tr>
                <td>Tổng</td>
                <td > </td>
                <td > </td>
                <td > </td>
                <td > &epsilon;q = </td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="31.50" step="0.1" name="CvarSumQtc" id="CvarSumQtc"></td>
                <td > <input class="form-control"   pattern="[0-9]*.[0-9]+" value="38.20" step="0.1" name="CvarSumQtt" id="CvarSumQtt"></td>
                <td >  kN/m <sup>2</sup>  </td>
            </tr>
            
        </table>

        <!-- <div class="text-center" style="margin-top: 10px">
            <img src="/images/21/hinh1.jpg" alt="Hình 1. Các trường hợp móng" width="500px">
        </div>
        <p class="text-center"><i>Hình 1. Các trường hợp móng</i></p> -->

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
    $(document).ready(function() {
        
        var arrI = <?php echo json_encode($arrI); ?>; 
        var arrW = <?php echo json_encode($arrW); ?>;
        var loai1 = $("#S-loai-1").val();
        console.log(arrI);

                $(".input-table-san").show();
                $(".input-table-dam").hide();
                $(".input-table-cot").hide();
                $("#title").text("TÍNH TOÁN CỐP PHA SÀN");
        $("#check-tang-ham").change(function() { showItem("#check-tang-ham", ".check-tang-ham-item"); });

        $("#loai").change(function() { 
            if ($("#loai").val() == "san") {
                $(".input-table-san").show();
                $(".input-table-dam").hide();
                $(".input-table-cot").hide();
                $("#title").text("TÍNH TOÁN CỐP PHA SÀN");
            } else if($("#loai").val() == "dam") {
                $(".input-table-san").hide();
                $(".input-table-dam").show();
                $(".input-table-cot").hide();
                $("#title").text("TÍNH TOÁN CỐP PHA DẦM");
            } else {
                $(".input-table-san").hide();
                $(".input-table-dam").hide();
                $(".input-table-cot").show();
                $("#title").text("TÍNH TOÁN CỐP PHA CỘT");
            }
        });

        $("#SvarH1").change(function() { 
            $("#SvarI1").val(($("#SvarB").val() * 100 * Math.pow($("#SvarH1").val() *100, 3) ) / 12 );
            $("#SvarW1").val(($("#SvarB").val() * 100 * Math.pow($("#SvarH1").val() *100, 2) ) / 6 );
        });
        $("#SvarB").change(function() { 
            $("#SvarI1").val(($("#SvarB").val() * 100 * Math.pow($("#SvarH1").val() *100, 3) ) / 12 );
            $("#SvarW1").val(($("#SvarB").val() * 100 * Math.pow($("#SvarH1").val() *100, 2) ) / 6 );
        });
        $("#DvarH1").change(function() { 
            $("#DvarI1").val(($("#DvarB").val() * 100 * Math.pow($("#DvarH1").val() *100, 3) ) / 12 );
            $("#DvarW1").val(($("#DvarB").val() * 100 * Math.pow($("#DvarH1").val() *100, 2) ) / 6 );
        });
        $("#DvarB").change(function() { 
            $("#DvarI1").val(($("#DvarB").val() * 100 * Math.pow($("#DvarH1").val() *100, 3) ) / 12 );
            $("#DvarW1").val(($("#DvarB").val() * 100 * Math.pow($("#DvarH1").val() *100, 2) ) / 6 );
        });
        $("#CvarH1").change(function() { 
            $("#CvarI1").val(($("#CvarB").val() * 100 * Math.pow($("#CvarH1").val() *100, 3) ) / 12 );
            $("#CvarW1").val(($("#CvarB").val() * 100 * Math.pow($("#CvarH1").val() *100, 2) ) / 6 );
        });
        $("#CvarB").change(function() { 
            $("#CvarI1").val(($("#CvarB").val() * 100 * Math.pow($("#CvarH1").val() *100, 3) ) / 12 );
            $("#CvarW1").val(($("#CvarB").val() * 100 * Math.pow($("#CvarH1").val() *100, 2) ) / 6 );
        });
        

        $("#SvarI2").val(arrI[$("#S-loai-1").val()]);
        $("#SvarW2").val(arrW[$("#S-loai-1").val()]);
        $("#SvarI3").val(arrI[$("#S-loai-2").val()]);
        $("#SvarW3").val(arrW[$("#S-loai-2").val()]);
        $("#DvarI2").val(arrI[$("#D-loai-1").val()]);
        $("#DvarW2").val(arrW[$("#D-loai-1").val()]);
        $("#DvarI3").val(arrI[$("#D-loai-2").val()]);
        $("#DvarW3").val(arrW[$("#D-loai-2").val()]);
        $("#CvarI2").val(arrI[$("#C-loai-1").val()]);
        $("#CvarW2").val(arrW[$("#C-loai-1").val()]);
        $("#CvarI3").val(arrI[$("#C-loai-2").val()]);
        $("#CvarW3").val(arrW[$("#C-loai-2").val()]);


        $("#S-loai-1").change(function() { 

            $("#SvarI2").val(arrI[$("#S-loai-1").val()]);
            $("#SvarW2").val(arrW[$("#S-loai-1").val()]);
        });
        $("#S-loai-2").change(function() { 

            $("#SvarI3").val(arrI[$("#S-loai-2").val()]);
            $("#SvarW3").val(arrW[$("#S-loai-2").val()]);
        });
        $("#D-loai-1").change(function() { 

            $("#DvarI2").val(arrI[$("#D-loai-1").val()]);
            $("#DvarW2").val(arrW[$("#D-loai-1").val()]);
        });
        $("#D-loai-2").change(function() { 

            $("#DvarI3").val(arrI[$("#D-loai-2").val()]);
            $("#DvarW3").val(arrW[$("#D-loai-2").val()]);
        });
        $("#C-loai-1").change(function() { 

            $("#CvarI2").val(arrI[$("#C-loai-1").val()]);
            $("#CvarW2").val(arrW[$("#C-loai-1").val()]);
        });
        $("#C-loai-2").change(function() { 

            $("#CvarI3").val(arrI[$("#C-loai-2").val()]);
            $("#CvarW3").val(arrW[$("#C-loai-2").val()]);
        });


        $("#SvarQtc1").change(function() { 
            $("#SvarQtt1").val(parseFloat($("#SvarQtc1").val())* parseFloat($("#SvarN1").val()));
            $("#SvarSumQtc").val( parseFloat($("#SvarQtc1").val())+parseFloat($("#SvarQtc2").val())+parseFloat($("#SvarQtc3").val())+parseFloat($("#SvarQtc4").val())+parseFloat($("#SvarQtc5").val()));
            $("#SvarSumQtt").val( parseFloat($("#SvarQtt1").val())+parseFloat($("#SvarQtt2").val())+parseFloat($("#SvarQtt3").val())+parseFloat($("#SvarQtt4").val())+parseFloat($("#SvarQtt5").val()));

        });
        $("#SvarQtc2").change(function() {
            $("#SvarQtt2").val($("#SvarQtc2").val()* $("#SvarN2").val());
            $("#SvarSumQtc").val( parseFloat($("#SvarQtc1").val())+parseFloat($("#SvarQtc2").val())+parseFloat($("#SvarQtc3").val())+parseFloat($("#SvarQtc4").val())+parseFloat($("#SvarQtc5").val()));
            $("#SvarSumQtt").val( parseFloat($("#SvarQtt1").val())+parseFloat($("#SvarQtt2").val())+parseFloat($("#SvarQtt3").val())+parseFloat($("#SvarQtt4").val())+parseFloat($("#SvarQtt5").val()));
        });
        $("#SvarQtc3").change(function() { 
            $("#SvarQtt3").val($("#SvarQtc3").val()* $("#SvarN3").val());
            $("#SvarSumQtc").val( parseFloat($("#SvarQtc1").val())+parseFloat($("#SvarQtc2").val())+parseFloat($("#SvarQtc3").val())+parseFloat($("#SvarQtc4").val())+parseFloat($("#SvarQtc5").val()));
            $("#SvarSumQtt").val( parseFloat($("#SvarQtt1").val())+parseFloat($("#SvarQtt2").val())+parseFloat($("#SvarQtt3").val())+parseFloat($("#SvarQtt4").val())+parseFloat($("#SvarQtt5").val()));
        });
        $("#SvarQtc4").change(function() { 
            $("#SvarQtt4").val($("#SvarQtc4").val()* $("#SvarN4").val());
            $("#SvarSumQtc").val( parseFloat($("#SvarQtc1").val())+parseFloat($("#SvarQtc2").val())+parseFloat($("#SvarQtc3").val())+parseFloat($("#SvarQtc4").val())+parseFloat($("#SvarQtc5").val()));
            $("#SvarSumQtt").val( parseFloat($("#SvarQtt1").val())+parseFloat($("#SvarQtt2").val())+parseFloat($("#SvarQtt3").val())+parseFloat($("#SvarQtt4").val())+parseFloat($("#SvarQtt5").val()));
        });
        $("#SvarQtc5").change(function() { 
            $("#SvarQtt5").val($("#SvarQtc5").val()* $("#SvarN5").val());
            $("#SvarSumQtc").val( parseFloat($("#SvarQtc1").val())+parseFloat($("#SvarQtc2").val())+parseFloat($("#SvarQtc3").val())+parseFloat($("#SvarQtc4").val())+parseFloat($("#SvarQtc5").val()));
            $("#SvarSumQtt").val( parseFloat($("#SvarQtt1").val())+parseFloat($("#SvarQtt2").val())+parseFloat($("#SvarQtt3").val())+parseFloat($("#SvarQtt4").val())+parseFloat($("#SvarQtt5").val()));
        });
        $("#DvarQtc1").change(function() { 
            $("#DvarQtt1").val($("#DvarQtc1").val()* $("#DvarN1").val());
            $("#DvarSumQtc").val( parseFloat($("DvarQtc1").val())+parseFloat($("#DvarQtc2").val())+parseFloat($("#DvarQtc3").val())+parseFloat($("#DvarQtc4").val())+parseFloat($("#DvarQtc5").val()));
            $("#DvarSumQtt").val( parseFloat($("DvarQtt1").val())+parseFloat($("#DvarQtt2").val())+parseFloat($("#DvarQtt3").val())+parseFloat($("#DvarQtt4").val())+parseFloat($("#DvarQtt5").val()));
        });
        $("#DvarQtc2").change(function() { 
            $("#DvarQtt2").val($("#DvarQtc2").val()* $("#DvarN2").val());
            $("#DvarSumQtc").val( parseFloat($("DvarQtc1").val())+parseFloat($("#DvarQtc2").val())+parseFloat($("#DvarQtc3").val())+parseFloat($("#DvarQtc4").val())+parseFloat($("#DvarQtc5").val()));
            $("#DvarSumQtt").val( parseFloat($("DvarQtt1").val())+parseFloat($("#DvarQtt2").val())+parseFloat($("#DvarQtt3").val())+parseFloat($("#DvarQtt4").val())+parseFloat($("#DvarQtt5").val()));
        });
        $("#DvarQtc3").change(function() { 
            $("#DvarQtt3").val($("#DvarQtc3").val()* $("#DvarN3").val());
            $("#DvarSumQtc").val( parseFloat($("DvarQtc1").val())+parseFloat($("#DvarQtc2").val())+parseFloat($("#DvarQtc3").val())+parseFloat($("#DvarQtc4").val())+parseFloat($("#DvarQtc5").val()));
            $("#DvarSumQtt").val( parseFloat($("DvarQtt1").val())+parseFloat($("#DvarQtt2").val())+parseFloat($("#DvarQtt3").val())+parseFloat($("#DvarQtt4").val())+parseFloat($("#DvarQtt5").val()));
        });
        $("#DvarQtc4").change(function() { 
            $("#DvarQtt4").val($("#DvarQtc4").val()* $("#DvarN4").val());
            $("#DvarSumQtc").val( parseFloat($("DvarQtc1").val())+parseFloat($("#DvarQtc2").val())+parseFloat($("#DvarQtc3").val())+parseFloat($("#DvarQtc4").val())+parseFloat($("#DvarQtc5").val()));
            $("#DvarSumQtt").val( parseFloat($("DvarQtt1").val())+parseFloat($("#DvarQtt2").val())+parseFloat($("#DvarQtt3").val())+parseFloat($("#DvarQtt4").val())+parseFloat($("#DvarQtt5").val()));
        });
        $("#DvarQtc5").change(function() { 
            $("#DvarQtt5").val($("#DvarQtc5").val()* $("#DvarN5").val());
            $("#DvarSumQtc").val( parseFloat($("DvarQtc1").val())+parseFloat($("#DvarQtc2").val())+parseFloat($("#DvarQtc3").val())+parseFloat($("#DvarQtc4").val())+parseFloat($("#DvarQtc5").val()));
            $("#DvarSumQtt").val( parseFloat($("DvarQtt1").val())+parseFloat($("#DvarQtt2").val())+parseFloat($("#DvarQtt3").val())+parseFloat($("#DvarQtt4").val())+parseFloat($("#DvarQtt5").val()));
        });

        $("#CvarQtc1").change(function() { 
            $("#CvarQtt1").val($("#CvarQtc1").val()* $("#CvarN1").val());
            $("#CvarSumQtc").val( parseFloat($("CvarQtc1").val())+parseFloat($("#CvarQtc2").val()));
            $("#CvarSumQtt").val( parseFloat($("CvarQtt1").val())+parseFloat($("#CvarQtt2").val()));
        });
        $("#CvarQtc2").change(function() { 
            $("#CvarQtt2").val($("#CvarQtc2").val()* $("#CvarN2").val());
            $("#CvarSumQtc").val( parseFloat($("CvarQtc1").val())+parseFloat($("#CvarQtc2").val()));
            $("#CvarSumQtt").val( parseFloat($("CvarQtt1").val())+parseFloat($("#CvarQtt2").val()));
        });
       
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

        
        data= {
                _token: CSRF_TOKEN,
                loai : $("#loai").val(),

                SvarHs : $('#SvarHs').val(),
                SvarGammab : $('#SvarGammab').val(),
                SvarH1 : $('#SvarH1').val(),
                SvarGamma1 : $('#SvarGamma1').val(),
                SvarB : $('#SvarB').val(),
                SvarI1 : $('#SvarI1').val(),
                SvarW1 : $('#SvarW1').val(),
                SvarSigma1 : $('#SvarSigma1').val(),
                SvarE1 : $('#SvarE1').val(),
                SvarGamma2 : $('#SvarGamma2').val(),
                SvarGamma3 : $('#SvarGamma3').val(),
                SvarI2 : $('#SvarI2').val(),
                SvarI3 : $('#SvarI3').val(),
                SvarW2 : $('#SvarW2').val(),
                SvarW3 : $('#SvarW3').val(),
                SvarSigma2 : $('#SvarSigma2').val(),
                SvarSigma3 : $('#SvarSigma3').val(),
                SvarE2 : $('#SvarE2').val(),
                SvarE3 : $('#SvarE3').val(),
                SvarS : $('#SvarS').val(),
                SvarP : $('#SvarP').val(),
                SvarL1 : $('#SvarL1').val(),
                SvarL2 : $('#SvarL2').val(),
                SvarL3 : $('#SvarL3').val(),
                SvarN1 : $('#SvarN1').val(),
                SvarN2 : $('#SvarN2').val(),
                SvarN3 : $('#SvarN3').val(),
                SvarN4 : $('#SvarN4').val(),
                SvarN5 : $('#SvarN5').val(),
                SvarQtc1 : $('#SvarQtc1').val(),
                SvarQtc2 : $('#SvarQtc2').val(),
                SvarQtc3 : $('#SvarQtc3').val(),
                SvarQtc4 : $('#SvarQtc4').val(),
                SvarQtc5 : $('#SvarQtc5').val(),
                SvarQtt1 : $('#SvarQtt1').val(),
                SvarQtt2 : $('#SvarQtt2').val(),
                SvarQtt3 : $('#SvarQtt3').val(),
                SvarQtt4 : $('#SvarQtt4').val(),
                SvarQtt5 : $('#SvarQtt5').val(),
                SvarSumQtc : $('#SvarSumQtc').val(),
                SvarSumQtt : $('#SvarSumQtt').val(),
                Sloai1 : $('#S-loai-1').val(),
                Sloai2 : $('#S-loai-2').val(),

                DvarHd : $('#DvarHd').val(),
                DvarBd : $('#DvarBd').val(),
                DvarGammab : $('#DvarGammab').val(),
                DvarH1 : $('#DvarH1').val(),
                DvarGamma1 : $('#DvarGamma1').val(),
                DvarB : $('#DvarB').val(),
                DvarI1 : $('#DvarI1').val(),
                DvarW1 : $('#DvarW1').val(),
                DvarSigma1 : $('#DvarSigma1').val(),
                DvarE1 : $('#DvarE1').val(),
                DvarGamma2 : $('#DvarGamma2').val(),
                DvarGamma3 : $('#DvarGamma3').val(),
                DvarI2 : $('#DvarI2').val(),
                DvarI3 : $('#DvarI3').val(),
                DvarW2 : $('#DvarW2').val(),
                DvarW3 : $('#DvarW3').val(),
                DvarSigma2 : $('#DvarSigma2').val(),
                DvarSigma3 : $('#DvarSigma3').val(),
                DvarE2 : $('#DvarE2').val(),
                DvarE3 : $('#DvarE3').val(),
                DvarS : $('#DvarS').val(),
                DvarP : $('#DvarP').val(),
                DvarL1 : $('#DvarL1').val(),
                DvarL2 : $('#DvarL2').val(),
                DvarL3 : $('#DvarL3').val(),
                DvarN1 : $('#DvarN1').val(),
                DvarN2 : $('#DvarN2').val(),
                DvarN3 : $('#DvarN3').val(),
                DvarN4 : $('#DvarN4').val(),
                DvarN5 : $('#DvarN5').val(),
                DvarQtc1 : $('#DvarQtc1').val(),
                DvarQtc2 : $('#DvarQtc2').val(),
                DvarQtc3 : $('#DvarQtc3').val(),
                DvarQtc4 : $('#DvarQtc4').val(),
                DvarQtc5 : $('#DvarQtc5').val(),
                DvarQtt1 : $('#DvarQtt1').val(),
                DvarQtt2 : $('#DvarQtt2').val(),
                DvarQtt3 : $('#DvarQtt3').val(),
                DvarQtt4 : $('#DvarQtt4').val(),
                DvarQtt5 : $('#DvarQtt5').val(),
                DvarSumQtc : $('#DvarSumQtc').val(),
                DvarSumQtt : $('#DvarSumQtt').val(),
                Dloai1 : $('#D-loai-1').val(),
                Dloai2 : $('#D-loai-2').val(),


                CvarHc : $('#CvarHc').val(),
                CvarGammab : $('#CvarGammab').val(),
                CvarH1 : $('#CvarH1').val(),
                CvarGamma1 : $('#CvarGamma1').val(),
                CvarB : $('#CvarB').val(),
                CvarI1 : $('#CvarI1').val(),
                CvarW1 : $('#CvarW1').val(),
                CvarSigma1 : $('#CvarSigma1').val(),
                CvarE1 : $('#CvarE1').val(),
                CvarGamma2 : $('#CvarGamma2').val(),
                CvarGamma3 : $('#CvarGamma3').val(),
                CvarI2 : $('#CvarI2').val(),
                CvarI3 : $('#CvarI3').val(),
                CvarW2 : $('#CvarW2').val(),
                CvarW3 : $('#CvarW3').val(),
                CvarSigma2 : $('#CvarSigma2').val(),
                CvarSigma3 : $('#CvarSigma3').val(),
                CvarE2 : $('#CvarE2').val(),
                CvarE3 : $('#CvarE3').val(),
                CvarD : $('#CvarD').val(),
                CvarSigma4 : $('#CvarSigma4').val(),
                CvarE22 : $('#CvarE22').val(),
                CvarL1 : $('#CvarL1').val(),
                CvarL2 : $('#CvarL2').val(),
                CvarL3 : $('#CvarL3').val(),
                CvarN1 : $('#CvarN1').val(),
                CvarN2 : $('#CvarN2').val(),
                CvarQtc1 : $('#CvarQtc1').val(),
                CvarQtc2 : $('#CvarQtc2').val(),
                CvarQtt1 : $('#CvarQtt1').val(),
                CvarQtt2 : $('#CvarQtt2').val(),
                CvarSumQtc : $('#CvarSumQtc').val(),
                CvarSumQtt : $('#CvarSumQtt').val(),
                Cloai1 : $('#C-loai-1').val(),
                Cloai2 : $('#C-loai-2').val(),

            };
        console.log(data);
        $.ajax({
            method: "POST",
            url: "/tinh-toan/tinh-toan-cop-pha",
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