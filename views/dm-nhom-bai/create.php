<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmNhomBai */

$this->title = 'Thêm danh mục nhóm bài tập';
$this->params['breadcrumbs'][] = ['label' => 'Danh mục nhóm bài tập', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-nhom-bai-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
