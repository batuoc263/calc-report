<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DmTinhtoanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cấu hình đường dẫn dm tính toán';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-tinhtoan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Thêm mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ten_bai_toan',
            'duong_dan',
            'luot_giai',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
