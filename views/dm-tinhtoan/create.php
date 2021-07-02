<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmTinhtoan */

$this->title = 'Thêm mới danh mục';
$this->params['breadcrumbs'][] = ['label' => 'Cấu hình danh mục tính toán', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->duong_dan = '#';
?>
<div class="dm-tinhtoan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
