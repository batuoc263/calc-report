<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Tính diện tích cốt thép';
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tinhtoan-content">
    <div class="col-md-9">
        <div class="text-center">
            <h1 class="text-uppercase" style="font-size: 25px;"><?= Html::encode($this->title) ?></h1>
        </div>

        <p class="text-justify">Trang tính này hỗ trợ tính toán diện tích cốt thép trong mặt cắt ngang của cấu kiện bê tông cốt thép.</p>
        <p>Yêu cầu chỉ định:</p>
        <ul>
            <li>Đường kính thanh thép và Số lượng thanh</li>
            <li>Đường kính thanh thép và Bước cốt thép/1m</li>
        </ul>
        <h3 style="font-size: 20px;" class="text-center">THÔNG SỐ ĐẦU VÀO</h3>

        <div style="margin-top: 15px">Đường kính thanh thép <i>d</i>, mm</div>
        <table class="diam" id="tb1">
            <tbody>
                <tr>
                    <td class="tddiam">3 </td>
                    <td class="tddiam">4 </td>
                    <td class="tddiam">5 </td>
                    <td class="tddiam">6 </td>
                    <td class="tddiam">8 </td>
                    <td class="tddiam">10</td>
                    <td class="tddiam">12</td>
                    <td class="tddiam">14</td>
                    <td class="tddiam">16</td>
                    <td class="tddiam">18</td>
                    <td class="tddiam">20</td>
                    <td class="tddiam">22</td>
                    <td class="tddiam">25</td>
                    <td class="tddiam">28</td>
                    <td class="tddiam">32</td>
                    <td class="tddiam">36</td>
                    <td class="tddiam">40</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 5px">Số lượng thanh thép <i>n</i>, thanh</div>
        <table class="diam" id="tb2">
            <tbody>
                <tr>
                    <td class="tdkolvo">1 </td>
                    <td class="tdkolvo">2 </td>
                    <td class="tdkolvo">3 </td>
                    <td class="tdkolvo">4 </td>
                    <td class="tdkolvo">5 </td>
                    <td class="tdkolvo">6 </td>
                    <td class="tdkolvo">7 </td>
                    <td class="tdkolvo">8 </td>
                    <td class="tdkolvo">9 </td>
                    <td class="tdkolvo">10</td>
                </tr>
                <tr>
                    <td class="tdkolvo">11</td>
                    <td class="tdkolvo">12</td>
                    <td class="tdkolvo">13</td>
                    <td class="tdkolvo">14</td>
                    <td class="tdkolvo">15</td>
                    <td class="tdkolvo">16</td>
                    <td class="tdkolvo">17</td>
                    <td class="tdkolvo">18</td>
                    <td class="tdkolvo">19</td>
                    <td class="tdkolvo">20</td>
                </tr>
                <tr>
                    <td class="tdkolvo">21</td>
                    <td class="tdkolvo">22</td>
                    <td class="tdkolvo">23</td>
                    <td class="tdkolvo">24</td>
                    <td class="tdkolvo">25</td>
                    <td class="tdkolvo">26</td>
                    <td class="tdkolvo">27</td>
                    <td class="tdkolvo">28</td>
                    <td class="tdkolvo">29</td>
                    <td class="tdkolvo">30</td>
                </tr>
                <tr>
                    <td class="tdkolvo">31</td>
                    <td class="tdkolvo">32</td>
                    <td class="tdkolvo">33</td>
                    <td class="tdkolvo">34</td>
                    <td class="tdkolvo">35</td>
                    <td class="tdkolvo">36</td>
                    <td class="tdkolvo">37</td>
                    <td class="tdkolvo">38</td>
                    <td class="tdkolvo">39</td>
                    <td class="tdkolvo">40</td>
                </tr>
                <tr>
                    <td class="tdkolvo">41</td>
                    <td class="tdkolvo">42</td>
                    <td class="tdkolvo">43</td>
                    <td class="tdkolvo">44</td>
                    <td class="tdkolvo">45</td>
                    <td class="tdkolvo">46</td>
                    <td class="tdkolvo">47</td>
                    <td class="tdkolvo">48</td>
                    <td class="tdkolvo">49</td>
                    <td class="tdkolvo">50</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 5px">Bước thép/1m <i>@</i>, mm</div>
        <table class="diam" id="tb3">
            <tbody>
                <tr>
                    <td class="tdkolvo">50 </td>
                    <td class="tdkolvo">100</td>
                    <td class="tdkolvo">150</td>
                    <td class="tdkolvo">200</td>
                    <td class="tdkolvo">250</td>
                    <td class="tdkolvo">300</td>
                    <td class="tdkolvo">350</td>
                    <td class="tdkolvo">400</td>
                    <td class="tdkolvo">450</td>
                    <td class="tdkolvo">500</td>
                    <td class="tdkolvo">550</td>
                    <td class="tdkolvo">600</td>
                </tr>
            </tbody>
        </table>

        <h3 style="font-size: 20px;" class="text-center">KẾT QUẢ TÍNH TOÁN</h3>

        <div id="rezblock" class="text-center">
            <p id="current_rez"><b id="rez">Chỉ định thông số đầu vào</b></p>
            <p><b id="cpy"></b></p>
            <p style="margin-top:7px;"><b id="sum">Σ <i>A<sub>s</sub></i> = <span id="tongAs">0</span></b></p>
        </div>

        <hr>
        <div class="row">
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

<script>
    $("#tb1").on("click", "td", function() {
        $('td').removeClass('tddiamblue');
        $(this).addClass("tddiamblue");

        tinhtoan();
    });
    $("#tb2").on("click", "td", function() {
        $('td').removeClass('tdkolvoblue');
        $(this).addClass("tdkolvoblue");

        tinhtoan();
    });
    $("#tb3").on("click", "td", function() {
        $('td').removeClass('tdkolvoblue');
        $(this).addClass("tdkolvoblue");

        tinhtoan();
    });

    function tinhtoan() {
        b1 = $('.tddiamblue')
        if (b1.length == 0) {
            console.log('Chọn đường kính thanh thép');
            $('#rez').html('<b>Chọn đường kính thanh thép </b>')
        }

        b2 = $('.tdkolvoblue')
        if (b2.length == 0) {
            console.log('Chọn số lượng thanh thép hoặc bước cốt thép');
            $('#rez').html('<b>Chọn số lượng thanh thép hoặc bước cốt thép </b>')
        }
        if (b1.length != 0 && b2.length != 0) {
            b1Val = b1[0].innerText
            b2Val = b2[0].innerText
            dientich = 0.25 * Math.PI * Math.pow(b1Val, 2)
            
            console.log('b1 = '+ b1Val+', b2 = '+b2Val+', dientich = '+dientich);
            cachTinh = b2[0].closest('table').id
            if (cachTinh == 'tb2') {
                As = dientich * b2Val;
                $('#current_rez').html('<b id="rez"><i>A<sub>s</sub></i> = ' + dientich.toFixed(2) + ' × ' + b2Val + ' = <span class="kqAs">' + As.toFixed(1) + '</span> mm² ('+b2Val+'d'+b1Val+') </b><span class="plus" title="Thêm">+</span>')
            } else {
                As = dientich * 1000/b2Val;
                $('#current_rez').html('<b id="rez"><i>A<sub>s</sub></i> = ' + dientich.toFixed(2) + ' × ' + (1000/b2Val).toFixed(2) + ' = <span class="kqAs">' + As.toFixed(1) + '</span> mm² (d'+b1Val+'@'+b2Val+') </b><span class="plus" title="Thêm">+</span>')
            }
        }
    }
</script>