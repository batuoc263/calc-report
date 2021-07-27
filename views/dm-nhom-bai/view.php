<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DmNhomBai */

$this->title = $model->ten;
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['/tinh-toan']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dm-nhom-bai-view">
    <div class="text-center bg-primary" style="border-radius: 5px;">
        <h1 class="text-uppercase" style="font-size: 25px; padding: 10px;"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="row">
        <?php foreach ($ds_bai_toan as $bt) { ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p><i class="glyphicon glyphicon-indent-left"></i> <a href="<?= $bt->duong_dan ?>"><?= $bt->ten_bai_toan ?></a></p>
                        Lượt giải: <span class="label <?= $bt->luot_giai > 0 ? 'label-primary' : 'label-default'?>"><?= $bt->luot_giai ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
