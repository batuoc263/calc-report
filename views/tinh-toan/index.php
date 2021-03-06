<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Tính toán';
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['index']];
?>
<div class="tinhtoan-content">

    <div class="col-md-9">
        <div class="text-center bg-primary" style="border-radius: 5px;">
            <h1 class="text-uppercase" style="font-size: 25px; padding: 10px; margin-top: 10px">Danh mục tính toán</h1>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="/dm-nhom-bai/view?id=2">
                    <img width="100%" height="360px" src="/images/tinh-toan/2_mong_coc.png" alt="Móng cọc">
                </a>
            </div>
            <div class="col-md-4">
                <div>
                    <a href="/dm-nhom-bai/view?id=1">
                        <img width="100%" height="180px" src="/images/tinh-toan/1_mong_nong.png" alt="Móng nông">
                    </a>
                </div>
                <div>
                    <a href="/dm-nhom-bai/view?id=3">
                        <img width="100%" height="180px" src="/images/tinh-toan/3_be_tong.png" alt="Bê tông">
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <a href="/dm-nhom-bai/view?id=4">
                    <img width="100%" height="360px" src="/images/tinh-toan/4_tai_trong_va_tac_dong.png" alt="Tải trọng và tác động">
                </a>
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-6">
                <a href="/dm-nhom-bai/view?id=5">
                    <img width="100%" height="180px" src="/images/tinh-toan/5_thi_cong.png" alt="Thi công">
                </a>
            </div>
            <div class="col-md-6">
                <a href="/dm-nhom-bai/view?id=6">
                    <img width="100%" height="180px" src="/images/tinh-toan/6_khac.png" alt="Khác">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 bg-primary round-top">
                <p style="padding-top: 10px;">Trên đây là danh mục hơn 20 nhiệm vụ cơ bản thường hay gặp trong tính toán thiết kế xây dựng bao gồm kết cấu phần ngầm và kết cấu thượng tầng, được thực hiện theo chỉ dẫn của tiêu chuẩn Việt Nam. Hy vọng sẽ giúp các bạn sinh viên củng cố và mở rộng kiến thức đã học để giải quyết những bài toán đặt ra</p>
            </div>
            <img width="100%" class="img-reflection" src="/images/tinh-toan/tinhtoan-index.jpg" alt="Khác">
        </div>
        
    </div>
    <div class="col-md-3">
        <?php
        foreach ($menu as $key => $value) { ?>
            
            <div class="text-center bg-success">
                <h4 style="padding: 5px;"><strong> <?= $value['ten'] ?> </strong></h4>
            </div>

            <ul class="nav nav-pills nav-stacked">
                <?php foreach ($value['children'] as $child) { ?>
                    <li><a href="<?= $child['duong_dan'] ?>"><?= $child['ten_bai_toan'] ?> <span class="badge"><?= $child['luot_giai'] ?></span></a></li>
                <?php } ?>
            </ul>

        <?php } ?>
    </div>
</div>