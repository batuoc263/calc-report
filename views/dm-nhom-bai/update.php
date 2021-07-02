<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmNhomBai */

$this->title = 'Cập nhật danh mục nhóm bài tập: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục nhóm bài tập', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="dm-nhom-bai-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
