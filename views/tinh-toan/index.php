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
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="col-md-3">
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => '',
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