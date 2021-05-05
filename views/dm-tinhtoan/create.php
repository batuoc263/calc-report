<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmTinhtoan */

$this->title = 'Create Dm Tinhtoan';
$this->params['breadcrumbs'][] = ['label' => 'Dm Tinhtoans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-tinhtoan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
